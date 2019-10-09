
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/loader/jquery.loader.min.css') !!}
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/css/formValidation.min.css') !!}
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/Tagator/fm.tagator.jquery.css') !!}
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/webuploader-0.1.5/webuploader.css') !!}
{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/dategrangepicker/daterangepicker.css') !!}



<style type="text/css">
    table.category_table > tbody > tr > td {
        border: none
    }

    .sp-require {
        color: red;
        margin-right: 5px
    }
</style>

<div class="tabs-container">

    {!! Form::open( [ 'url' => [route('edu.discount.store')], 'method' => 'POST', 'id' => 'create-discount-form','class'=>'form-horizontal'] ) !!}
    <input type="hidden" value="{{$discount->id}}" name="id">
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                <div class="col-sm-8">
                    <fieldset class="form-horizontal">
                        @include('edu-backend::discount.coupon.includes.edit_base')
                    </fieldset>

                    <fieldset class="form-horizontal">
                        @include('edu-backend::discount.coupon.edit_rule')
                    </fieldset>

                    <fieldset class="form-horizontal">
                       @include('edu-backend::discount.coupon.includes.edit_action')
                    </fieldset>
                </div>

            </div>
        </div>
    </div>

    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button class="btn btn-primary" type="submit">保存设置</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>


@include('edu-backend::discount.coupon.includes.script')

{!! Html::script(env("APP_URL").'/vendor/libs/jquery.form.min.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/webuploader-0.1.5/webuploader.js') !!}

<script>
    $(function () {

        $('#create-discount-form').ajaxForm({
            success: function (result) {
                if (result.status) {
                    swal({
                        title: "保存成功！",
                        text: "",
                        type: "success"
                    }, function () {
                        window.location = '{{route('edu.discount.index')}}';
                    });
                } else {
                    swal("保存失败!", result.message, "error")
                }

            }
        });
    });

    //action Initialization
    var value = $('.action-select').children('option:selected').val();

    if(value == 'course_order_fixed_discount') {
        var action_html = $('#discount_action_template').html();
    }

    if(value == 'course_order_percentage_discount') {
        var action_html = $('#percentage_action_template').html();
    }
    $('#promotion-action').html(action_html.replace(/{VALUE}/g, '{{$discount->discountAction?$discount->discountAction->ActionValue: 0}}'))



    var postImgUrl = '{{url('cdn/upload?_token='.csrf_token())}}';
    var uploader = WebUploader.create({
        auto: true,
        swf: '{{url(env("APP_URL").'/assets/backend/libs/webuploader-0.1.5/Uploader.swf')}}',
        server: postImgUrl,
        pick: '#filePicker',
        fileVal: 'upload_file',
        accept: {
            title: 'Images',
            extensions: 'jpg,jpeg,png',
            mimeTypes: 'image/jpg,image/jpeg,image/png'
        }
    });
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess', function (file, response) {
        $('#activity-poster img').attr("src", response.data.url);
        $('#activity-poster input').val( response.data.url);
    });

</script>

