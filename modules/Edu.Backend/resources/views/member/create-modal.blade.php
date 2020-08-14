@extends('edu-backend::layouts.bootstrap_modal')

@section('modal_class')
    modal-lg
@stop

@section('title')
    添加学员
@stop

@section('body')
    <form id="student-create-form" class="form-horizontal" method="post"
          action="{{route('edu.course.member.store',['id'=>$course->id])}}"
          novalidate="novalidate" data-widget-cid="widget-4">
        {{csrf_field()}}
        <div class="row form-group">
            <div class="col-md-2 control-label">
                <label for="student-nickname">学员账号</label>
            </div>
            <div class="col-md-7 controls">
                <input type="text" id="student-nickname" name="nickname" class="form-control" data-widget-cid="widget-5"
                       data-explain="只能添加系统中已注册的用户">
                <div class="help-block" id="user-help-block">只能添加系统中已注册的用户</div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-2 control-label">
                <label for="buy-price">购买价格</label>
            </div>
            <div class="col-md-7 controls">
                <input type="text" id="buy-price" name="price" value="0" class="form-control" data-widget-cid="widget-7"
                       data-explain="本课程的价格为0.00元">
                <div class="help-block">本课程的价格为{{$course->price/100}}元</div>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-md-2 control-label">
                <label for="student-remark">备注</label>
            </div>
            <div class="col-md-7 controls">
                <input type="text" id="student-remark" name="remark" class="form-control" data-widget-cid="widget-6"
                       data-explain="选填">
                <div class="help-block">选填</div>
            </div>
        </div>


    </form>
@stop

@section('footer')
    <button type="button" class="btn btn-link" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary pull-right" data-toggle="form-submit"
            data-target="#student-create-form">保存
    </button>

    <script>
        $(function () {
            $('#student-create-form').formValidation({
                framework: 'bootstrap',
                fields: {
                    nickname: {
                        validators: {
                            notEmpty: {
                                message: '请输入学员用户名'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();

                $.post($("#student-create-form").attr('action'), $("#student-create-form").serialize(), function (result) {
                    if (result.status) {
                         window.location.reload();
                    } else {
                        swal(result.message, "", "error")
                    }
                });
            });


        })
    </script>
@stop

