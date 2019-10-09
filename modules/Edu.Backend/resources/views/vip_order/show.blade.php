<div class="tabs-container">
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body form-horizontal">

                <div class="form-group">
                    <label class="control-label col-md-2">订单编号：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->order_no}}</p>
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
                        <p class="form-control-static">{{$order->user->user_name}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">邮箱：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->user->email}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">电话：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->user->mobile}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">所属VIP计划：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->plan->title}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">支付状态：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->status==2?'已支付':'待支付'}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">应付金额：</label>
                    <div class="col-md-9">
                        <p class="form-control-static">{{$order->price/100}}元</p>
                    </div>
                </div>

                @if($order->status)
                    <div class="form-group">
                        <label class="control-label col-md-2">支付时间：</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{$order->paid_at}}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-2">交易流水号：</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{$order->transaction_no}}</p>
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