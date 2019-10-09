<h4>基本规则</h4>
<hr class="hr-line-solid">

<!--订单总金额-->
@if($item_total=$discount->discount_item_total)
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <label>
                <input checked type="checkbox" name="rules[1][type]"
                       value="item_total" class="switch-input"> 课程订单总金额满
            </label>
            <span class="sw-hold" style="display: none">XX</span>
            <input type="text" name="rules[1][value]" class="sw-value" value="{{$item_total->RulesValue / 100}}">元
        </div>
    </div>
@else
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <label>
                <input type="checkbox" name="rules[1][type]"
                       value="item_total" class="switch-input"> 课程订单总金额满
            </label>
            <span class="sw-hold">XX</span>
            <input type="text" style="display: none" name="rules[1][value]" class="sw-value">元
        </div>
    </div>
@endif
<!--订单总金额 end-->
<div class="hr-line-dashed"></div>



