<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/14
 * Time: 18:41
 */

namespace GuoJiangClub\Edu\Backend\Http\Controllers;


use iBrand\Backend\Http\Controllers\Controller;
use GuoJiangClub\Edu\Backend\Models\Category;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $group_id = request('group_id');
        switch ($group_id) {
            case 1:
                $title = '课程方向';
                break;
            case 2:
                $title = '课程形式';
                break;
            case 3:
                $title = '课程标签';
                break;
            default:
                $title = '课程方向';
        }

        $categories = Category::where('groupId', $group_id)->orderBy('weight','desc')->paginate(15);


        return LaravelAdmin::content(function (Content $content) use ($categories, $group_id, $title) {

            $content->header($title . '管理');

            $content->breadcrumb(
                ['text' => $title . '管理', 'url' => '', 'no-pjax' => 1],
                ['text' => $title . '列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => $title]
            );

            $content->body(view('edu-backend::category.index', compact('categories', 'group_id', 'title')));
        });


    }

    public function create()
    {
        $group_id = request('group_id');
        switch ($group_id) {
            case 1:
                $title = '课程方向';
                break;
            case 2:
                $title = '课程形式';
                break;
            case 3:
                $title = '课程标签';
                break;
            default:
                $title = '课程方向';
        }

        return LaravelAdmin::content(function (Content $content) use ($group_id, $title) {

            $content->header($title . '管理');

            $content->breadcrumb(
                ['text' => $title . '管理', 'url' => '', 'no-pjax' => 1],
                ['text' => $title . '列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => $title]
            );

            $content->body(view('edu-backend::category.create', compact('group_id', 'title')));
        });
    }

    public function edit($id)
    {
        $category = Category::find($id);
        switch ($category->groupId) {
            case 1:
                $title = '课程方向';
                break;
            case 2:
                $title = '课程形式';
                break;
            case 3:
                $title = '课程标签';
                break;
            default:
                $title = '课程方向';
        }
        return LaravelAdmin::content(function (Content $content) use ($category, $title) {

            $content->header($title . '管理');

            $content->breadcrumb(
                ['text' => $title . '管理', 'url' => '', 'no-pjax' => 1],
                ['text' => $title . '列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => $title]
            );

            $content->body(view('edu-backend::category.edit', compact('category', 'title')));
        });
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $validator = $this->validateForm($id);

        if ($validator->fails()) {
            $warnings = $validator->messages();
            $show_warning = $warnings->first();

            return $this->ajaxJson(false, [], 500, $show_warning);
        }

        if ($id) {
            $category = Category::find($id);
            $category->fill($request->except(['id', '_token']));
            $category->save();
        } else {
            Category::create($request->except('_token'));
        }

        return $this->ajaxJson();

    }

    protected function validateForm($id = 0)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'weight' => 'required|integer'
        ];

        $message = [
            "required" => ":attribute 不能为空",
            "integer" => ":attribute 必须是整数",
            "unique" => ":attribute 已经存在",
        ];

        $attributes = [
            "name" => '分类名称',
            "code" => '编码',
            "weight" => '排序'
        ];

        $validator = Validator::make(request()->all(), $rules, $message, $attributes);

        $validator->sometimes('code', "unique:" . config('ibrand.app.database.prefix', 'ibrand_') . "edu_category,code,$id", function ($input) {
            return $input->id;
        });

        $validator->sometimes('code', "unique:" . config('ibrand.app.database.prefix', 'ibrand_') . "edu_category,code", function ($input) {
            return !$input->id;
        });
        return $validator;
    }

    public function delete()
    {
        $id = request('id');
        $category = Category::find($id);
        if ($category->courses->count()) {
            return $this->ajaxJson(false, [], 500, '该分类下存在课程，不可删除');
        }

        $category->delete();
        return $this->ajaxJson();
    }
}