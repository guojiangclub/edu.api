<div class="tabs-container">
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                {!! Form::open( [ 'route' => ['edu.svip.order.list'], 'method' => 'get', 'id' => 'commentsurch-form','class'=>'form-horizontal'] ) !!}
                <div class="row">
                    <div class="col-sm-2">
                        <select name="status" class="form-control">
                            <option value="">请选择支付状态</option>
                            <option value="2" {{request('status')==2?'selected':''}}>已支付</option>
                            <option value="1" {{request('status')==1?'selected':''}}>待支付</option>
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="user_name" value="{{request('user_name')}}" placeholder="请输入用户名"
                                   class=" form-control"> <span
                                    class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">查找</button></span></div>
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
                                <th>邮箱</th>
                                <th>电话</th>
                                <th>所属VIP计划</th>
                                <th>金额（元）</th>
                                <th>支付状态</th>
                                <th>操作</th>
                            </tr>
                            <!--tr-th end-->
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{$order->order_no}}</td>
                                    <td>{{$order->user->user_name}}</td>
                                    <td>{{$order->user->email}}</td>
                                    <td>{{$order->user->mobile}}</td>
                                    <td>{{$order->plan->title}}</td>
                                    <td>{{$order->price/100}}</td>
                                    <td>
                                        {!! $order->status==2?'已支付<br>支付时间：'.$order->paid_at:'待支付' !!}
                                    </td>
                                    <td>
                                        <a
                                                class="btn btn-xs btn-primary"
                                                href="{{route('edu.svip.order.show',['id'=>$order->id])}}" no-pjax>
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
