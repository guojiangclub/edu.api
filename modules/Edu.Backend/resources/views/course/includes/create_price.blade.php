<div class="form-group">
    <label class="col-sm-2 control-label">价格（元）：</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="price" placeholder="">
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">是否促销：</label>
    <div class="col-sm-10">
        <label>
            <input type="radio" name="is_discount" value="0" checked>
            否
        </label>

        <label>
            <input type="radio" name="is_discount" value="1"> 是
        </label>
    </div>
</div>


<div class="form-group discount-div" style="display: none">
    <label class="col-sm-2 control-label">促销价格（元）：</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="discount_price" placeholder="">
    </div>
</div>

<div class="form-group discount-div" style="display: none">
    <label class="col-sm-2 control-label">促销时间：</label>
    <div class="col-sm-10" id="two-inputs">
        <div class="col-sm-6">
            <div class="input-group date form_datetime" id="start_at">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;开始</span>
                <input type="text" name="discount_start_time" class="form-control inline" id="date-range200" size="20"
                       value=""
                       placeholder="点击选择时间" readonly>

                <span class="add-on"><i class="icon-th"></i></span>
            </div>
            <div id="date-range12-container"></div>
        </div>

        <div class="col-sm-6">
            <div class="input-group date form_datetime" id="end_at">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;截止</span>

                <input type="text" name="discount_end_time" class="form-control inline" id="date-range201" value=""
                       placeholder="" readonly>
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
        </div>
    </div>
</div>


