<h4>优惠动作</h4>
<hr class="hr-line-solid">

<div class="form-group">
    <label class="col-sm-2 control-label">金额类型：</label>
    <div class="col-sm-10">
        <select class="form-control m-b action-select" name="action[type]" onchange="actionChange(this)">
            <option selected="selected" value="course_order_fixed_discount">课程订单减金额
            </option>
            <option value="course_order_percentage_discount">课程订单打折
            </option>

        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2" id="promotion-action">
        <div class="input-group m-b">
            <span class="input-group-addon">$</span>
            <input class="form-control" type="text" name="action[configuration]" value="0">
        </div>
    </div>
</div>


@include('edu-backend::discount.coupon.template')