<div class="form-group">
    {!! Form::label('name','是否促销：', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-9">
        <label class="checkbox-inline i-checks"><input name="is_discount" type="radio" value="0" checked> 否</label>
        <label class="checkbox-inline i-checks"><input name="is_discount" type="radio" value="1" > 是</label>
    </div>
</div>

<div id="discount_area" style="display: none">
    <div class="form-group">
        <label class="col-sm-2 control-label">促销价格：</label>
        <div class="col-sm-10">
            <div class="input-group m-b">
                <input class="form-control" value="0"
                       name="discount_price" type="text"> <span
                        class="input-group-addon">元</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">促销时间：</label>
        <div class="col-sm-10" id="two-inputs">
            <div class="col-sm-6">
                <div class="input-group date form_datetime" id="start_at">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;开始</span>
                    <input type="text" name="discount_starts_at" class="form-control inline" id="date-range200" size="20"
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

                    <input type="text" name="discount_ends_at" class="form-control inline" id="date-range201" value=""
                           placeholder="" readonly>
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
