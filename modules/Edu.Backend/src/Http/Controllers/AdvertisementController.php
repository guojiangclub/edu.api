<?php

namespace GuoJiangClub\Edu\Backend\Http\Controllers;

use iBrand\Backend\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use iBrand\Component\Advert\Repositories\AdvertItemRepository;
use iBrand\Component\Advert\Repositories\AdvertRepository;
use Illuminate\Http\Request;
use Validator;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $advertisementRepository;
    protected $advertisementItemRepository;

    public function __construct(AdvertRepository $advertRepository,
                                AdvertItemRepository $advertisementItemRepository
    )
    {
        $this->advertisementRepository = $advertRepository;
        $this->advertisementItemRepository = $advertisementItemRepository;
    }

    public function index()
    {
        $advertisement = $this->advertisementRepository->orderBy('updated_at', 'desc')->paginate(20);

        return LaravelAdmin::content(function (Content $content) use ($advertisement) {

            $content->header('推广位管理');

            $content->breadcrumb(
                ['text' => '推广位管理管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '推广位列表', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '推广管理']
            );

            $content->body(view('edu-backend::advertisement.ad.index', compact('advertisement')));
        });
    }

    public function create()
    {
        return LaravelAdmin::content(function (Content $content) {
            $content->description('添加推广位');

            $content->breadcrumb(
                ['text' => '推广位列表', 'url' => 'cms/ad', 'no-pajx' => 1],
                ['text' => '添加推广位', 'left-menu-active' => '推广管理']
            );

            $content->body(view('edu-backend::advertisement.ad.create'));
        });
    }

    public function store(Request $request)
    {
        $input = $request->except('_token', 'file');
        $rules = [
            'name' => 'required',
            'code' => 'required',
        ];
        $message = [
            'required' => ':attribute 不能为空',
        ];
        $attributes = [
            'name' => '推广位名称',
            'code' => 'Code编码',
        ];
        $validator = Validator::make($input, $rules, $message, $attributes);
        if ($validator->fails()) {
            $warnings = $validator->messages();
            $show_warning = $warnings->first();

            return $this->ajaxJson(false, [], 500, $show_warning);
        }

        if (request('id')) {
            $this->advertisementRepository->update($input, request('id'));
        } else {
            $this->advertisementRepository->create($input);
        }

        return $this->ajaxJson();
    }


    public function edit($id)
    {
        $advertisement_list = $this->advertisementRepository->findByField('id', $id)->first();

        return LaravelAdmin::content(function (Content $content)use ($advertisement_list) {
            $content->description('添加推广位');

            $content->breadcrumb(
                ['text' => '推广位列表', 'url' => 'cms/ad', 'no-pajx' => 1],
                ['text' => '添加推广位', 'left-menu-active' => '推广管理']
            );

            $content->body(view('edu-backend::advertisement.ad.edit',compact('advertisement_list')));
        });
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adItem = $this->advertisementItemRepository->findByField('ad_id', $id)->first();
        if (is_null($adItem)) {
            $this->advertisementRepository->delete($id);
            return $this->ajaxJson();
        }

        return $this->ajaxJson(false, [], 200, '推广位下非空删除失败');
    }

    public function toggleStatus(Request $request)
    {
        $status = request('status');
        $id = request('aid');
        $user = Advertisement::find($id);
        $user->fill($request->only('status'));
        $user->save();

        return response()->json(
            ['status' => true
                , 'code' => 200
                , 'message' => ''
                , 'data' => []]
        );
    }

}
