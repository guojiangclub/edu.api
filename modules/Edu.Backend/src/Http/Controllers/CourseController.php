<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/14
 * Time: 19:33
 */

namespace iBrand\Edu\Backend\Http\Controllers;

use DB;
use Carbon\Carbon;
use iBrand\Backend\Http\Controllers\Controller;
use iBrand\Edu\Backend\Models\Category;
use iBrand\Edu\Backend\Models\Course;
use iBrand\Edu\Backend\Repositories\CourseRepository;
use iBrand\Edu\Backend\Repositories\CourseTeacherRepository;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseRepository;

    protected $courseTeacherRepository;

    public function __construct(CourseRepository $courseRepository,CourseTeacherRepository $courseTeacherRepository)
    {
        $this->courseRepository = $courseRepository;

        $this->courseTeacherRepository=$courseTeacherRepository;

    }

    public function updatePicture(){

        $all=$this->courseRepository->all();

        $filtered = $all->filter(function ($value, $key) {

            $picture=$value->picture;

            if(env('HOME_SITE')){

                $res= str_replace(env('HOME_SITE'),"https://cdn.hellobi.com",$picture);

                $value->picture=$res;

                if($res=='/images/default/course-default-475x250.png'){

                    $value->picture='https://cdn.hellobi.com'.$res;
                }

                $value->save();

            }else{

              if(strpos($picture,'https://')!==0
                AND strpos($picture,'http://')!==0
                AND strpos($picture,'/images/default/')!==0){
                if(strpos($picture,'/uploads/')===0){
                    $value->picture='https://cdn.hellobi.com'.$picture;
                    $value->save();
                }
              }

            }
        });
        dd('ok');
    }



    public function index()
    {
        if (!request('status')) {
            $where['status'] = 'published';
        } else {
            $where['status'] = request('status');
        }

        if (request('title')) {
            $where['title'] = ['like', '%' . request('title') . '%'];
        }

        if (request('recommended') == 'recommended') {
            $where['recommended'] = 1;
        } elseif (request('recommended') == 'unrecommended') {
            $where['recommended'] = 0;
        }

        $categoryID = [];
        if (request('category_id')) {
            $categoryID = [request('category_id')];
        }

        $courses = $this->courseRepository->getCoursePaginate($where, $categoryID);
        $categories = Category::all();

        return LaravelAdmin::content(function (Content $content) use ($courses, $categories) {

            $content->header('课程列表');

            $content->breadcrumb(
                ['text' => '所有课程', 'url' => 'edu/course/list', 'no-pjax' => 1],
                ['text' => '课程列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '所有课程']

            );

            $content->body(view('edu-backend::course.index', compact('courses', 'categories')));
        });

    }

    public function create()
    {
        $categories = Category::all();

        return LaravelAdmin::content(function (Content $content) use ($categories) {

            $content->header('添加课程');

            $content->breadcrumb(
                ['text' => '所有课程', 'url' => 'edu/course/list', 'no-pjax' => 1],
                ['text' => '添加课程', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '所有课程']

            );

            $content->body(view('edu-backend::course.create', compact('categories')));
        });
    }

    public function edit($id)
    {

        $course= $this->courseRepository->find($id);

        $teacher=$this->courseTeacherRepository->findByField('course_id',$id)->first();

        if($teacher){

            $teacher->avatar=getHellobiAvatar($teacher->avatar);

            $teacher->nick_name=$teacher->name;

            $teacher->id=$teacher->user_id;

        }

        $course_categories = $course->categories()->get();

        $categories = Category::all();

        return LaravelAdmin::content(function (Content $content) use ($categories,$course,$teacher,$course_categories) {

            $dataCategory = '';

            $dataShape='';

            $dataTag='';

            if($course_categories->count()){

                foreach ($course_categories as $item){

                    if($item->groupId==2){

                        $dataShape.=$item->id.'_';
                    }

                    if($item->groupId==1){

                        $dataCategory.=$item->id.'_';
                    }

                    if($item->groupId==3){

                        $dataTag.=$item->id.'_';
                    }

                }
            }

            $content->header('编辑课程');

            $content->breadcrumb(
                ['text' => '所有课程', 'url' => 'edu/course/list', 'no-pjax' => 1],
                ['text' => '编辑课程', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '所有课程']

            );



            $content->body(view('edu-backend::course.edit', compact('categories','course','teacher','dataCategory','dataShape','dataTag')));
        });
    }


    public function store(Request $request)
    {

        try {

            DB::beginTransaction();

            $course=$request->only('title','picture','price','subtitle','about',

                'expiry_day','price','is_discount','discount_price','discount_start_time','discount_end_time');

            $course['price']=$course['price']?$course['price']*100:0;

            $course['discount_price']=$course['discount_price']?$course['discount_price']*100:0;

            $course['user_id'] = isset(auth('admin')->user()->id)?auth('admin')->user()->id:0;

            $course['recommended_seq']=0;

            if(!empty($course['about'])){
                $regex = "/src=\"\/uploads\/ueditor\/php\//";
                $num_matches = preg_replace($regex, 'src="' . $request->server()['HTTP_ORIGIN'] . '/uploads/ueditor/php/', $course['about']);
                $regex = "/src=\"\/files\/course\//";
                $num_matches = preg_replace($regex, 'src="' . $request->server()['HTTP_ORIGIN'] . '/files/course/', $num_matches);
                $course['about'] = $num_matches;
            }

            $course=$this->courseRepository->create($course);

           if ($courseTags = $request->input('courseTags')) {

                foreach ($courseTags as $key => $value) {
                    $categories[$value] = ['group_id' => 3];
                }
            }



            if ($courseShapes = $request->input('courseShapes')) {
                foreach ($courseShapes as $key => $value) {
                    $categories[$value] = ['group_id' => 2];
                }
            }
            if ($courseCategories = $request->input('courseCategories')) {

                foreach ($courseCategories as $key => $value) {
                    $categories[$value] = ['group_id' => 1];
                }
            }

            $course->categories()->sync($categories);

            $ids=request('ids');

            if($ids AND count($ids)){

                foreach ($ids as $user_id){

                    $user_model=config('auth.providers.users.model');

                    $user =new $user_model;

                    $user =$user->find($user_id);

                    $this->courseTeacherRepository->create(['user_id'=>$user->id,

                        'name'=>$user->nick_name,'course_id'=>$course->id,'avatar'=>$user->avatar]);

                }
            }

            DB::commit();

            return $this->ajaxJson(true,$course);

        } catch (\Exception $e) {

            DB::rollBack();

            \Log::info($e);

            return $this->ajaxJson(false, [], 400,'保存失败');

        }

    }

    public function update(Request $request){

        try {


            DB::beginTransaction();

            $course=$request->only('title','picture','price','subtitle','about',

                'expiry_day','price','is_discount','discount_price','discount_start_time','discount_end_time');

            $course['price']=$course['price']?$course['price']*100:0;

            $course['discount_price']=$course['discount_price']?$course['discount_price']*100:0;

            $course['user_id'] = isset(auth('admin')->user()->id)?auth('admin')->user()->id:0;

            $id=request('id');

            if(!empty($course['about'])){
                $regex = "/src=\"\/uploads\/ueditor\/php\//";
                $num_matches = preg_replace($regex, 'src="' . $request->server()['HTTP_ORIGIN'] . '/uploads/ueditor/php/', $course['about']);
                $regex = "/src=\"\/files\/course\//";
                $num_matches = preg_replace($regex, 'src="' . $request->server()['HTTP_ORIGIN'] . '/files/course/', $num_matches);
                $course['about'] = $num_matches;
            }

            $course=$this->courseRepository->update($course,$id);

            if ($courseTags = $request->input('courseTags')) {

                foreach ($courseTags as $key => $value) {
                    $categories[$value] = ['group_id' => 3];
                }
            }

            if ($courseShapes = $request->input('courseShapes')) {
                foreach ($courseShapes as $key => $value) {
                    $categories[$value] = ['group_id' => 2];
                }
            }
            if ($courseCategories = $request->input('courseCategories')) {

                foreach ($courseCategories as $key => $value) {
                    $categories[$value] = ['group_id' => 1];
                }
            }

            $course->categories()->sync($categories);

            $ids=request('ids');

            if($ids AND count($ids)){

                foreach ($ids as $user_id){

                    $user_model=config('auth.providers.users.model');

                    $user =new $user_model;

                    $user =$user->find($user_id);

                    $this->courseTeacherRepository->deleteWhere(['course_id'=>$course->id]);

                    $this->courseTeacherRepository->create(['user_id'=>$user->id,

                        'name'=>$user->nick_name,'course_id'=>$course->id,'avatar'=>$user->avatar]);

                }
            }

          DB::commit();

            return $this->ajaxJson(true,$course);

        } catch (\Exception $e) {

            DB::rollBack();

            \Log::info($e);

            return $this->ajaxJson(false, [], 400,'保存失败');

        }

    }


    /**
     * 修改课程推荐状态
     * @param $id
     * @return mixed
     */
    public function switchRecommend($id)
    {
        $course = $this->courseRepository->find($id);

        if (!$course) return $this->ajaxJson(false, [], 500, '课程不存在');

        if ($course->recommended) {  //取消推荐
            $course->recommended = 0;
        } else {
            $course->recommended = 1;
            $course->recommended_time = Carbon::now();
        }
        $course->save();

        return $this->ajaxJson();

    }

    /**
     * 修改课程发布状态
     * @param $id
     * @return mixed
     */
    public function switchStatus($id)
    {
        $course = $this->courseRepository->find($id);

        if (!$course) return $this->ajaxJson(false, [], 500, '课程不存在');

        if ($course->status == 'closed' || $course->status == 'draft') {  //发布课程
            $course->status = 'published';
        } else {    //关闭课程
            $course->status = 'closed';
        }
        $course->save();

        return $this->ajaxJson();
    }
}