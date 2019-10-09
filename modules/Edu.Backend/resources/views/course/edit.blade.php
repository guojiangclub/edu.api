{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/webuploader-0.1.5/webuploader.css') !!}
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/select2/select2.min.css') !!}
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/awesomplete/awesomplete.css') !!}
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/dategrangepicker/daterangepicker.css') !!}

<style type="text/css">
    .teacher-list-group .nickname {
        display: inline-block;
        width: 160px;
        margin-left: 6px;
    }
    .teacher-list-group .delete-btn {
        margin-top: 12px;
    }
    .avatar-small {
        width: 50px;
        height: 50px;
    }
</style>

<div class="tabs-container" id="wizard">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">基本信息<i
                        class="glyphicon"></i></a></li>
        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">详细信息<i class="glyphicon"></i></a>
        </li>
        <li><a href="#tab_3" data-toggle="tab" data-type="ue"
               aria-expanded="false">价格设置</a></li>
    </ul>

    {!! Form::open( [ 'url' => [route('edu.course.update',$course->id)], 'method' => 'POST', 'id' => 'base-form','class'=>'form-horizontal'] ) !!}
    <div class="tab-content items">
        <div class="tab-pane active" id="tab_1">
            <div class="panel-body">
                @include('edu-backend::course.includes.edit_base')
            </div><!-- /.tab-pane -->
        </div>


        <div class="tab-pane" id="tab_2">
            <div class="panel-body">
                <script id="container" name="about"
                        type="text/plain">{!! $course->about!!}</script>
            </div>
        </div>

        <div class="tab-pane" id="tab_3">
            <div class="panel-body">
                @include('edu-backend::course.includes.edit_price')
            </div>

        </div><!-- /.tab-pane -->

        <div class="ibox-content m-b-sm border-bottom text-right">
            <input type="hidden" name="id" value="{{$course->id}}">
            <input type="submit" class="btn btn-success" data-toggle="form-submit" data-target="#base-form"
                   value="保存">
        </div>


    </div><!-- /.tab-content -->
    {!! Form::close() !!}
</div>

@include('UEditor::head')
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/alpaca-spa-2.1.js') !!}
{!! Html::script(env("APP_URL").'/vendor/libs/jquery.form.min.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/webuploader-0.1.5/webuploader.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/select2/select2.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/awesomplete/awesomplete.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/dategrangepicker/moment.min.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/dategrangepicker/jquery.daterangepicker.js') !!}

@include('edu-backend::course.includes.cr_script')


<script>

    $(function () {

        $('input[name=is_discount]').on('ifClicked', function(e){
            var that=$(this);
            var val=that.val()
            if(val==1){
                $('.discount-div').show();
            }else{
                $('.discount-div').hide();
                var price= $('input[name=price]').val()
                $('input[name=discount_start_time]').val('');
                $('input[name=discount_price]').val(price)
                $('input[name=discount_end_time]').val('')
            }
        });


        var dataShape = "{{$dataShape}}";
        var shapeSelect  =  $("#course-xingshi").select2();
        shapeSelect.val(dataShape.split('_')).trigger("change");

        var dataTag = "{{$dataTag}}";
        var tagSelect =  $("#course-tag").select2();
        tagSelect.val(dataTag.split('_')).trigger("change");

        var dataCategory = "{{$dataCategory}}";

        var categorySelect = $("#course-category").select2();
        categorySelect.val(dataCategory.split('_')).trigger("change");

        Alpaca.Tpl({data:data ,from:"#teacher-template", to:"#teacher-content"});

        var ids=data.result;

        $('#base-form').ajaxForm({
            beforeSubmit: function (data) {
                var input = [];
                $.each(data, function (k, v) {
                    if (v.name !== "lenght") {
                        input[v.name] = v.value;
                    }
                })
                console.log(input);
                if(input.title==''){
                    swal("保存失败!", '请填写课程标题', "error");
                    return false;
                }
                if(ids.length>1){
                    swal("保存失败!", '只允许添加一位教师', "error");
                    return false;
                }
                if(ids.length==0){
                    swal("保存失败!", '请添加一位教师', "error");
                    return false;
                }
            },
            success: function (result) {
                if (!result.status) {
                    swal("保存失败!", result.message, "error")
                } else {
                    console.log(result);
                    swal({
                        title: "保存成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        window.location.href="{{route('edu.course.list')}}"+'?status='+result.data.status;
                    });
                }

            }
        });
    })
</script>