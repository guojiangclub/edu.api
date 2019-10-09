<div class="tabs-container">
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                {!! Form::open( [ 'route' => ['edu.order.list'], 'method' => 'get', 'id' => 'commentsurch-form','class'=>'form-horizontal'] ) !!}
                <div class="row">
                    <div class="col-sm-2">
                        <select name="status" class="form-control">
                            <option value="">请选择支付状态</option>
                            <option value="paid" {{request('status')=='paid'?'selected':''}}>已支付</option>
                            <option value="created" {{request('status')=='created'?'selected':''}}>待支付</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select class="form-control" name="field">
                            <option value="sn" {{request('field')=='sn'?'selected':'sn'}} >订单号</option>
                            <option value="title" {{request('field')=='title'?'selected':''}} >课程</option>
                            <option value="mobile" {{request('field')=='mobile'?'selected':''}} >手机</option>
                            <option value="user_name" {{request('field')=='user_name'?'selected':''}} >用户名</option>
                            <option value="email" {{request('field')=='email'?'selected':'email'}} >邮箱</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="value" value="{{request('value')}}" placeholder=""
                                   class=" form-control"> <span
                                    class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">查找</button>
                                         <a href=""  style="margin-left: 10px;" type="button" class="btn btn-primary">重置</a>
                    </span></div>

                    </div>
                </div>
                {!! Form::close() !!}

                <div class="hr-line-dashed"></div>

                <div class="table-responsive">
                    @if(count($orders)>0)
                        <table class="table table-hover table-striped">
                            <tbody>
                            <!--tr-th start-->
                            <tr>
                                <th>订单编号</th>
                                <th>用户名</th>
                                <th>电话</th>
                                <th>邮箱</th>
                                <th width="300">课程</th>
                                <th>金额（元）</th>
                                <th>支付状态</th>
                                <th>操作</th>
                            </tr>
                            <!--tr-th end-->
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{$order->sn}}</td>
                                    <td>{{isset($order->user->user_name)?$order->user->user_name:''}}</td>
                                    <td>{{isset($order->user->mobile)?$order->user->mobile:''}}</td>
                                    <td>{{isset($order->user->email)?$order->user->email:''}}</td>
                                    <td>
                                        @if(isset($order->course->id))

                                            @if($order->course->discount_price<=0)
                                            <span class="label">免费课程</span>
                                            @endif
                                           <a href="{{route('edu.course.edit',$order->course->id)}}" target="_blank">
                                               {{isset($order->course->title)?$order->course->title:''}}
                                           </a>

                                        @endif
                                    </td>
                                    <td>{{$order->total/100}}</td>
                                    <td>
                                        {!! !empty($order->paid_at)?'已支付<br>支付时间：'.$order->paid_at:'待支付' !!}
                                    </td>
                                    <td>
                                        <a
                                                class="btn btn-xs btn-primary"
                                                href="{{route('edu.order.show',['id'=>$order->id])}}" no-pjax>
                                            <i data-toggle="tooltip" data-placement="top"
                                               class="fa fa-eye"
                                               title="编辑"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="8" class="footable-visible">
                                    {!! $orders->appends(request()->except('page'))->render() !!}
                                </td>
                            </tr>
                            </tfoot>
                            @else
                                <div>
                                    &nbsp;&nbsp;&nbsp;当前无数据
                                </div>
                            @endif
                        </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</div>
