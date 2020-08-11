    <div class="ibox float-e-margins">
        <div class="ibox-content" style="display: block;">
            {!! Form::open( [ 'url' => [route('edu.ad.store')], 'method' => 'POST','id' => 'base-form','class'=>'form-horizontal'] ) !!}
            <input type="hidden" name="id" value="">
            <div class="form-group">
                {!! Form::label('name','推广位名称：', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="name" placeholder="">
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('name','Code编码：', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="code"  placeholder="">
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('name','是否可用：', ['class' => 'col-lg-2 control-label']) !!}
                <div class="col-lg-9">
                    <div class="radio">
                        <label>
                            <input type="radio" name="status" value="1" checked="">
                            是
                        </label>
                        <label>
                            <input type="radio" name="status" value="0">
                            否
                        </label>
                    </div>
                </div>
            </div>

            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8 controls">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @include('edu-backend::advertisement.ad.script')