<div class="form-group">
    <label class="col-sm-2 control-label">价格（元）：</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="price" placeholder="" value="{{$course->price/100}}">
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">是否促销：</label>
    <div class="col-sm-10">
        <label>
            <input type="radio" name="is_discount" value="0"

                   @if($course->is_discount==0)
                   checked
                   @endif

            >
            否
        </label>

        <label>
            <input type="radio" name="is_discount" value="1"

                   @if($course->is_discount==1)
                   checked
                    @endif

            > 是
        </label>
    </div>
</div>


<div class="form-group discount-div" @if($course->is_discount==0)  style="display: none"  @endif>
    <label class="col-sm-2 control-label">促销价格（元）：</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="discount_price" placeholder="" value="{{$course->discount_price/100}}">
    </div>
</div>

<div class="form-group discount-div" @if($course->is_discount==0)  style="display: none"  @endif  >
    <label class="col-sm-2 control-label">促销时间：</label>
    <div class="col-sm-10" id="two-inputs">
        <div class="col-sm-6">
            <div class="input-group date form_datetime" id="start_at">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;开始</span>
                <input type="text" name="discount_start_time" class="form-control inline" id="date-range200" size="20"
                       value="{{$course->discount_start_time}}"
                       placeholder="点击选择时间" readonly>

                <span class="add-on"><i class="icon-th"></i></span>
            </div>
            <div id="date-range12-container"></div>
        </div>

        <div class="col-sm-6">
            <div class="input-group date form_datetime" id="end_at">
                                        <span class="input-group-addon" style="cursor: pointer">
                                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;截止</span>

                <input type="text" name="discount_end_time" class="form-control inline" id="date-range201" value=" {{$course->discount_end_time}}"
                       placeholder="" readonly>
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
        </div>
    </div>
</div>