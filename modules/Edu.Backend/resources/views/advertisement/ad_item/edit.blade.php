<div class="ibox float-e-margins">
    <div class="ibox-content" style="display: block;">
        {!! Form::open( [ 'url' => [route('edu.ad.item.store')], 'method' => 'POST','id' => 'base-form','class'=>'form-horizontal'] ) !!}
        <input type="hidden" name="advert_id" value="{{$ad_id}}">
        <input type="hidden" name="id" value="{{$aditem_list->id}}">

        <div class="form-group">
            {!! Form::label('name','推广名称：', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-9">
                <input type="text" class="form-control" name="name" placeholder="" value="{{$aditem_list->name}}">
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('name','推广展示图片：', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-9">
                <input type="hidden" name="image" value="{{$aditem_list->image}}"/>
                <img class="banner-image" style="max-height: 186px;" src="{{$aditem_list->image}}">
                <div id="filePicker">选择图片</div>
            </div>
        </div>


        <div class="form-group">
            {!! Form::label('name','链接地址：', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-9">
                <input type="text" class="form-control" name="link" placeholder="如果不做跳转请勿填写"
                       value="{{$aditem_list->link}}">
                @if(str_contains($ad->code,'Mini') OR str_contains($ad->code,'CategoryList'))
                    <span class="help-block m-b-none">商城首页地址：/pages/index/index/index</span>
                    <span class="help-block m-b-none">商品详情地址：/pages/store/detail/detail?id=XXX，请用真实商品ID替代XXX</span>
                    <span class="help-block m-b-none">商品列表地址：/pages/store/list/list?c_id=XXX，请用真实分类ID替代XXX</span>
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('name','排序：', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-9">
                <input type="text" class="form-control" name="sort" placeholder="" value="{{$aditem_list->sort}}">

            </div>
        </div>


        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8 controls">
                <button type="submit" class="btn btn-primary">保存</button>
            </div>
        </div>
    {!! Form::close() !!}


    <!-- /.tab-content -->
    </div>


</div>


@include('edu-backend::advertisement.ad_item.script')