<div class="ibox float-e-margins">
    <div class="ibox-content" style="display: block;">
        {!! Form::open( [ 'url' => [route('edu.category.store')], 'method' => 'POST', 'id' => 'base-form','class'=>'form-horizontal'] ) !!}

        <input type="hidden" name="id" value="{{$category->id}}">
        <div class="form-group">
            {!! Form::label('name','编码：', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-9">
                <input type="text" class="form-control" name="code" value="{{$category->code}}" placeholder="纯英文编码，请勿输入重复名称">
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('spec','名称：', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-9" id="spec_box">
                <input type="text" class="form-control" name="name" value="{{$category->name}}" placeholder="中文显示名称">
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('spec','排序：', ['class' => 'col-lg-2 control-label']) !!}
            <div class="col-lg-9">
                <input type="text" class="form-control" name="weight"  value="{{$category->weight}}" placeholder="数字，值大排在前面">
            </div>
        </div>

        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8 controls">
                <a class="btn btn-white" href="{{route('edu.category.list',['group_id'=>$category->groupId])}}">取消</a>

                <button type="submit" class="btn btn-primary">保存</button>
            </div>
        </div>

        {!! Form::close() !!}
                <!-- /.tab-content -->
    </div>
</div>

{!! Html::script(env("APP_URL").'/vendor/libs/jquery.form.min.js') !!}

<script>
    $('#base-form').ajaxForm({
        success: function (result) {
            if (!result.status) {
                swal("保存失败!", result.message, "error")
            } else {
                swal({
                    title: "保存成功！",
                    text: "",
                    type: "success"
                }, function () {
                    window.location = '{{route('edu.category.list',['group_id'=>$category->groupId])}}'
                });
            }

        }
    });
</script>