<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/14
 * Time: 19:35
 */

namespace iBrand\Edu\Backend\Http\Controllers;


use iBrand\Backend\Http\Controllers\Controller;
use iBrand\Edu\Backend\Models\VipPlan;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use iBrand\Edu\Core\Models\VipMember;
use iBrand\Edu\Core\Models\CourseOrder;
use iBrand\Edu\Core\Models\CourseOrderAdjustment;


class SvipController extends Controller
{
    public function index()
    {
        $status = 1;
        if (request('status') == 'invalid') {
            $status = 0;
        }

        $query = VipPlan::where('status', $status);

        if (request('title')) {
            $query = $query->where('title', 'like', '%' . request('title') . '%');
        }
        $plans = $query->paginate(15);

        return LaravelAdmin::content(function (Content $content) use ($plans) {

            $content->header('SVIP计划管理');

            $content->breadcrumb(
                ['text' => 'SVIP计划管理', 'url' => '', 'no-pjax' => 1],
                ['text' => 'SVIP计划列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => 'SVIP计划管理']
            );

            $content->body(view('edu-backend::plan.index', compact('plans')));
        });
    }

    public function create()
    {
        return LaravelAdmin::content(function (Content $content) {

            $content->header('添加SVIP计划');

            $content->breadcrumb(
                ['text' => 'SVIP计划管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '添加SVIP计划', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => 'SVIP计划管理']
            );

            $content->body(view('edu-backend::plan.create'));
        });
    }

    public function edit($id)
    {
        $plan = VipPlan::find($id);
        return LaravelAdmin::content(function (Content $content) use ($plan) {

            $content->header('修改SVIP计划');

            $content->breadcrumb(
                ['text' => 'SVIP计划管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '修改SVIP计划', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => 'SVIP计划管理']
            );

            $content->body(view('edu-backend::plan.edit', compact('plan')));
        });
    }

    public function store(Request $request)
    {
        $validator = $this->validateForm();

        if ($validator->fails()) {
            $warnings = $validator->messages();
            $show_warning = $warnings->first();

            return $this->ajaxJson(false, [], 500, $show_warning);
        }

        $data = $request->except(['_token', 'hour', 'minute', 'id']);

        if ($request->input('id')) {
            $plan = VipPlan::find($request->input('id'));
            $plan->fill($data);
            $plan->save();
        } else {
            VipPlan::create($data);
        }

        return $this->ajaxJson();
    }

    protected function validateForm()
    {
        $rules = [
            'title' => 'required',
            'price' => 'required',
            'days' => 'required|integer',
            'actions.free_course' => 'required|integer',
            'actions.course_discount_percentage' => 'required|numeric|between:1,99',
        ];

        $message = [
            "required" => ":attribute 不能为空",
            "integer" => ":attribute 必须是整数",
            "numeric" => ":attribute 必须是数字",
            "between" => ':attribute 课程折扣值最小为1，最大为99'
        ];

        $attributes = [
            "title" => '活动名称',
            "price" => '价格',
            "days" => '有效期',
            "actions.free_course" => '免费课程数',
            "actions.course_discount_percentage" => '购买课程折扣',
            "discount_price" => '促销价格'
        ];

        $validator = Validator::make(request()->all(), $rules, $message, $attributes);

        $validator->sometimes('discount_price', "required", function ($input) {
            return $input->is_discount == 1;
        });

        return $validator;
    }

    public function updateDataVipMember(){

        $time=Carbon::now()->addYear(-1)->toDateTimeString();

        $pay_at_00= DB::table('svip2018')->where('status',1)->where('pay_at','0000-00-00 00:00:00')->get();

        if($pay_at_00->count()){

            foreach ($pay_at_00 as $item){

                DB::table('svip2018')->where('id',$item->id)->update(['pay_at'=>$item->created_at]);

            }
        }

        $list=DB::table('svip2018')->where('status',1)->where('user_id','>',0)->whereNotNull('pay_at')->where('pay_at','>',$time)->get();


        $vip=VipPlan::where('status',1)->where('price','99800')->first();

        if(!$vip){

            echo '998会员不存在';return;
        }

        $user_ids=[];

        $joined_at=[];

        foreach ($list as $item){

            $deadline_time =Carbon::parse($item->pay_at)->addYear(1)->toDateTimeString();
            $user_ids[]=$item->user_id;


            $joined_at[$item->user_id]=$item->pay_at;


            //更新VipMember
            if(empty(request('page'))){

                VipMember::firstOrCreate(['plan_id'=>$vip->id,
                    'order_id'=>0,'user_id'=>$item->user_id,'joined_at'=>$item->pay_at,'deadline'=>$deadline_time]);
            }

        }

        //统计会员数量

        $server_time=Carbon::now()->toDateTimeString();

        $vip_member_count=VipMember::where('plan_id',$vip->id)->where('deadline','>',$server_time)->count();

        $vip->member_count=$vip_member_count;

        $vip->save();


        //获订单
        $course_order=CourseOrder::where('status','paid')

            ->whereIn('user_id',$user_ids)

            ->with('course')

            ->whereHas('course',function ($query){

                return $query=$query->where('price','>',0);
            })

            ->where('total',0)

            ->where('paid_at','>',$time)->paginate(1000);

            if($course_order->count()){

                foreach ($course_order as $item){

                   if($item->paid_at>$joined_at[$item->user_id]){

                       $data=[
                           'order_id'=>$item->id,
                           'type'=>'vip_discount',
                           'label'=>'VIP会员折扣',
                           'amount'=>-$item->course->price,
                           'origin_type'=>'vip',
                           'origin_id'=>$vip->id
                       ];

                       //更新CourseOrderAdjustment
                       CourseOrderAdjustment::firstOrCreate($data);
                   }

                }
            }

        $page=request('page')?request('page'):1;

        $last_page=$course_order->lastPage();

        echo '当前第'.$page.'页<br>总共'.$last_page.'页<br>';

        if($page!=$last_page){

            echo '请点击下一页继续更新<br><a href="'.$course_order->nextPageUrl().'">下一页</a>';
        }

        dd('ok');

    }

}