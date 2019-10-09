<h4>优惠动作</h4>
<hr class="hr-line-solid">



<div class="form-group">
    <label class="col-sm-2 control-label">金额类型：</label>
    <div class="col-sm-10">

        @if(isset($discount->discountAction->id))
        <input type="hidden" value="{{$discount->discountAction->id}}" name="action_id">
        @else
         <input type="hidden" value=0 name="action_id">
        @endif

        <select class="form-control m-b action-select" name="action[type]" onchange="actionChange(this)">
            <?php $type = $discount->discountAction ? $discount->discountAction->type : null; ?>
            <option selected="selected" value="course_order_fixed_discount"
                    {{$type == 'course_order_fixed_discount'?'selected' : ''}}>课程订单减金额
            </option>
            <option value="course_order_percentage_discount"
                    {{$type == 'course_order_percentage_discount'?'selected' : ''}}>课程订单打折
            </option>

        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2" id="promotion-action">

    </div>
</div>

@include('edu-backend::discount.coupon.template')

