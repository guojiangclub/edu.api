
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/datepicker/bootstrap-datetimepicker.min.css') !!}

<div class="tabs-container">
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">

            {!! Form::open( [ 'route' => ['edu.discount.useRecord'], 'method' => 'get', 'id' => 'recordSearch-form','class'=>'form-horizontal'] ) !!}
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="col-sm-6">
                            <div class="input-group date form_datetime">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;使用时间</span>
                                <input type="text" class="form-control inline" name="stime"
                                       value="{{request('stime')}}" placeholder="开始" readonly>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group date form_datetime">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control" name="etime" value="{{request('etime')}}"
                                       placeholder="截止" readonly>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="field">
                            <option value="sn" {{request('field')=='sn'?'selected':''}} >订单号</option>
                            <option value="mobile" {{request('field')=='mobile'?'selected':''}} >手机</option>
                            <option value="user_name" {{request('field')=='user_name'?'selected':''}} >用户名</option>
                            <option value="email" {{request('field')=='email'?'selected':'email'}} >邮箱</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" name="value" value="{{request('value')}}" placeholder="Search"
                                   class=" form-control"> <span
                                    class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">查找</button>
                                        <a href="{{route('edu.discount.useRecord',['id'=>request('id')])}}"  style="margin-left: 10px;" type="button" class="btn btn-primary">重置</a>
                            </span></div>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{$id}}">
                {!! Form::close() !!}


                <div class="table-responsive">
                    <div id="coupons">
                        <div class="hr-line-dashed"></div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <tbody>
                                <!--tr-th start-->
                                <tr>
                                    {{--<th><input type="checkbox" class="check-all"></th>--}}
                                    <th>使用时间</th>
                                    <th>优惠券</th>
                                    {{--<th>优惠券码</th>--}}
                                    <th>订单编号</th>
                                    <th>订单总金额</th>
                                    <th>订单状态</th>
                                    <th>用户名</th>
                                    <th>邮箱</th>
                                    <th>电话</th>
                                </tr>
                                @if($coupons->count()>0)
                                    <!--tr-th end-->
                                    @foreach ($coupons as $coupon)
                                        <tr class="coupon{{$coupon->id}}">
                                            {{--<td><input class="checkbox" type="checkbox" value="{{$coupon->id}}" name="ids[]"></td>--}}
                                            <td>{{$coupon->created_at}}</td>
                                            <td>{{$coupon->label}}</td>
                                            {{--<td>{{$coupon->code}}</td>--}}
                                            <td>{{$coupon->order->sn}}</td>
                                            <td>{{$coupon->order->total/100}}</td>
                                            <td>
                                                @if($coupon->order->status=='paid')
                                                    已支付
                                                @else
                                                    待付款
                                                @endif
                                            </td>

                                            <td>{{$coupon->order->user?($coupon->order->user->user_name?$coupon->order->user->user_name:''):''}}</td>
                                            <td>{{$coupon->order->user?($coupon->order->user->email?$coupon->order->user->email:''):''}}</td>
                                            <td>{{$coupon->order->user?($coupon->order->user->mobile?$coupon->order->user->mobile:''):''}}</td>

                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <div class="pull-left">
                                &nbsp;&nbsp;共&nbsp;{!! $coupons->total() !!} 条记录
                            </div>

                            <div class="pull-right">
                                {!! $coupons->appends(request()->except('page'))->render() !!}
                            </div>
                            <!-- /.box-body -->
                        </div>

                    </div>
                </div><!-- /.box-body -->
            </div>

        </div>
    </div>
</div>



{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/datepicker/bootstrap-datetimepicker.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/datepicker/bootstrap-datetimepicker.zh-CN.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/loader/jquery.loader.min.js') !!}
{{--{!! Html::script(env("APP_URL").'/assets/backend/libs/jquery.el/el.common.js') !!}--}}


<script>
    $('.form_datetime').datetimepicker({
        minView: 0,
        format: "yyyy-mm-dd hh:ii:ss",
        autoclose: 1,
        language: 'zh-CN',
        weekStart: 1,
        todayBtn: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: true,
        minuteStep: 1,
        maxView: 4
    });

</script>






