<div class="tabs-container">
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body form-horizontal">

                <div class="form-group">
                    <label class="control-label col-md-2">订单编号：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->sn}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">下单时间：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->created_at}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">用户名：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->user?$order->user->user_name:''}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">邮箱：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->user?$order->user->email:''}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">电话：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->user?$order->user->mobile:''}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">课程：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->course->title}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">支付状态：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->status=='paid'?'已支付':'待支付'}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">应付金额：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->total/100}}元</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">优惠金额：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->adjustments_total/100}}元</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">支付类型：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$payment}}</p>
                    </div>
                </div>

                @if($order->status)
                    <div class="form-group">
                        <label class="control-label col-md-2">支付时间：</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{$order->paid_at}}</p>
                        </div>
                    </div>

                @endif

                <input type="hidden" name="id" value="{{$order->id}}">

                <div class="ibox-content m-b-sm border-bottom">
                    <a class="btn btn-white" onclick="javascript:history.go(-1);">返回</a>
                </div>
            </div>

        </div>

    </div>

</div>