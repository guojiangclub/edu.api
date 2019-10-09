<div class="form-group">
    {!! Form::label('name','活动名称：', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-9">
        <input type="text" class="form-control" name="title" value="{{$plan->title}}">
    </div>
</div>

<div class="form-group">
    {!! Form::label('name','价格：', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-9">
        <div class="input-group m-b">
            <input class="form-control" value="{{$plan->price}}"
                   name="price" type="text"> <span
                    class="input-group-addon">元</span>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('name','会员有效期天数：', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-9">
        <div class="input-group m-b">
            <input class="form-control" value="{{$plan->days}}"
                   name="days" type="text"> <span
                    class="input-group-addon">天</span>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('name','VIP权益：', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-9">
        <div class="input-group m-b"><span class="input-group-addon">可免费课程：</span>
            <input type="text" name="actions[free_course]" class="form-control" value="{{$plan->actions['free_course']}}">
            <span class="input-group-addon">门</span>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-9 col-sm-offset-2">
        <div class="input-group m-b"><span class="input-group-addon">购买课程折扣：</span>
            <input type="text" name="actions[course_discount_percentage]" class="form-control"  value="{{$plan->actions['course_discount_percentage']}}">
            <span class="input-group-addon">%</span>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('name','状态：', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-9">
        <div class="input-group m-b">
            <label class="checkbox-inline i-checks"><input name="status" type="radio" value="1"

                                                           @if($plan->status==1)
                                                           checked @endif

                > 有效</label>
            <label class="checkbox-inline i-checks"><input name="status" type="radio" value="0" @if($plan->status==0)
                checked @endif> 失效</label>
        </div>
    </div>
</div>