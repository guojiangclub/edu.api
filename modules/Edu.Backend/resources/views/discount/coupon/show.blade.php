
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/datepicker/bootstrap-datetimepicker.min.css') !!}

<div class="ibox float-e-margins">
    <div class="ibox-content" style="display: block;">
        {!! Form::open( [ 'route' => ['edu.discount.showCoupons'], 'method' => 'get', 'id' => 'recordSearch-form','class'=>'form-horizontal'] ) !!}
        <div class="row">
            <div class="col-md-7">
                <div class="col-sm-6">
                    <div class="input-group date form_datetime">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;领取时间</span>
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
                    <option value="mobile" {{request('field')=='mobile'?'selected':''}} >手机</option>
                    <option value="user_name" {{request('field')=='user_name'?'selected':''}} >用户名</option>
                    <option value="email" {{request('field')=='email'?'selected':'email'}} >邮箱</option>
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" name="value" value="{{request('value')}}" placeholder=""
                           class=" form-control"> <span
                            class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">查找</button>
                                         <a href="{{route('edu.discount.showCoupons',['id'=>request('id')])}}"  style="margin-left: 10px;" type="button" class="btn btn-primary">重置</a>
                    </span></div>

            </div>

        </div>
        <input type="hidden" name="id" value="{{$id}}">
        {!! Form::close() !!}

        <div class="hr-line-dashed"></div>

        @if($coupons->count()>0)
            <div class="box-body table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                    <!--tr-th start-->
                    <tr>
                        <th>领取时间</th>
                        <th>优惠券码</th>
                        <th>用户名</th>
                        <th>邮箱</th>
                        <th>电话</th>
                        <th>是否使用</th>
                        <th>使用时间</th>
                    </tr>
                    <!--tr-th end-->
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{$coupon->created_at}}</td>
                            <td>{{$coupon->code}}</td>
                            <td>{{$coupon->user?($coupon->user->user_name?$coupon->user->user_name:''):''}}</td>
                            <td>{{$coupon->user?($coupon->user->email?$coupon->user->email:''):''}}</td>
                            <td>{{$coupon->user?($coupon->user->mobile?$coupon->user->mobile:''):''}}</td>
                            <td>
                                @if(!$coupon->used_at)
                                    <label class="label label-danger">No</label>
                                @else
                                    <label class="label label-success">Yes</label>
                                @endif
                            </td>
                            <td>{{$coupon->used_at}}</td>

                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->

            <div class="pull-left">
                &nbsp;&nbsp;共&nbsp;{!! $coupons->total() !!} 条记录
            </div>

            <div class="pull-right">
                {!! $coupons->appends(request()->except('page'))->render() !!}
            </div>
        @else
            &nbsp;&nbsp;&nbsp;当前无数据
        @endif

        <div class="box-footer clearfix">
        </div>
    </div>

</div>


{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/datepicker/bootstrap-datetimepicker.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/datepicker/bootstrap-datetimepicker.zh-CN.js') !!}

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


