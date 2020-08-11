<?php

namespace GuoJiangClub\Edu\Backend\Http\Controllers;

use iBrand\Backend\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin as LaravelAdmin;
use Encore\Admin\Layout\Content;
use iBrand\Component\Advert\Models\AdvertItem;
use iBrand\Component\Advert\Repositories\AdvertItemRepository;
use iBrand\Component\Advert\Repositories\AdvertRepository;
use Illuminate\Http\Request;

use Route;
use Validator;

class AdvertisementItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $advertisementRepository;
    protected $advertisementItemRepository;
    protected $goodsRepository;

    public function __construct(AdvertRepository $advertisementRepository
        , AdvertItemRepository $advertisementItemRepository
    )
    {
        $this->advertisementRepository = $advertisementRepository;
        $this->advertisementItemRepository = $advertisementItemRepository;
    }

    public function index()
    {
        if (empty(request('ad_id'))) {
            return redirect()->route('edu.ad.list');
        }

        $ad_items = $this->advertisementItemRepository->orderBy('sort')->findByField('advert_id', request('ad_id'))->all();

        return LaravelAdmin::content(function (Content $content) use ($ad_items) {

            $content->header('推广位管理');

            $content->breadcrumb(
                ['text' => '推广位管理管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '推广位详情', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '推广管理']
            );

            $content->body(view('edu-backend::advertisement.ad_item.index', compact('ad_items')));
        });
    }

    public function create()
    {
        if (empty(request('ad_id'))) {
            return redirect()->route('edu.ad.list');
        }

        $ad_id = request('ad_id');
        $ad = $this->advertisementRepository->find($ad_id);

        return LaravelAdmin::content(function (Content $content) use ($ad_id, $ad) {

            $content->header('推广位管理');

            $content->breadcrumb(
                ['text' => '推广位管理管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '添加推广', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '推广管理']
            );

            $content->body(view('edu-backend::advertisement.ad_item.create', compact('ad')));
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token', 'file');
        $rules = [
            //'name' => 'required',
            'sort' => "required | integer | min:0",

        ];
        $message = [
            "required" => ":attribute 不能为空",
            "integer" => ":attribute 必须是整数",
            "min" => ":attribute 非负数最小为0",
        ];
        $attributes = [
            'name' => '推广名称',
            'sort' => '排序',
        ];
        $validator = Validator::make($input, $rules, $message, $attributes);
        if ($validator->fails()) {
            $warnings = $validator->messages();
            $show_warning = $warnings->first();

            return $this->ajaxJson(false, [], 500, $show_warning);
        }

        if (request('id')) {
            $ad = $this->advertisementItemRepository->update($input, request('id'));
        } else {
            $ad = $this->advertisementItemRepository->create($input);
        }

        return $this->ajaxJson(true, ['ad_id' => $ad->advert_id, 'id' => $ad->id]);
    }

    public function edit($id)
    {
        $ad_id = request('ad_id');
        $child = [];
        $aditem_list = $this->advertisementItemRepository->findByField('id', $id)->first();

        $ad = $this->advertisementRepository->find($ad_id);

        return LaravelAdmin::content(function (Content $content) use ($aditem_list, $ad_id, $child, $ad) {

            $content->header('推广位管理');

            $content->breadcrumb(
                ['text' => '推广位管理管理', 'url' => '', 'no-pjax' => 1],
                ['text' => '添加推广', 'url' => '', 'no-pjax' => 1, 'left-menu-active' => '推广管理']
            );

            $content->body(view('edu-backend::advertisement.ad_item.edit', compact('aditem_list', 'ad_id', 'child', 'ad')));
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
        $this->advertisementItemRepository->delete($id);
        return $this->ajaxJson();
    }

    public function toggleStatus(Request $request)
    {
        $status = request('status');
        $id = request('aid');
        $user = AdvertItem::find($id);
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
