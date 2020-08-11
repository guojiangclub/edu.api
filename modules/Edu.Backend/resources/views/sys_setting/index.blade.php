<div class="ibox float-e-margins">
    <div class="ibox-content" style="display: block;">
        <form method="post" action="{{route('edu.settings.saveSettings')}}" class="form-horizontal"
              id="setting_site_form">
            {{csrf_field()}}


            <div class="form-group">
                <label class="col-sm-2 control-label">客服二维码：</label>
                <div class="col-sm-10">
                    <input type="hidden" name="online_service_self[qr_code]"
                           value="{{isset(settings('online_service_self')['qr_code'])?settings('online_service_self')['qr_code']:''}}">
                    <img class="course_paid_success_banner"
                         src="{{isset(settings('online_service_self')['qr_code'])?settings('online_service_self')['qr_code']:''}}"
                         alt="" style="max-width: 300px;">
                    <div id="videoPicker">选择图片</div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <button class="btn btn-primary" type="submit">保存设置</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(function () {

        $('#setting_site_form').ajaxForm({
            success: function (result) {
                swal({
                    title: "保存成功！",
                    text: "",
                    type: "success"
                }, function () {
                    location.reload();
                });

            }
        });


        //上传banner
        var uploader2 = WebUploader.create({
            auto: true,
            swf: '{{url(env("APP_URL").'/assets/backend/libs/webuploader-0.1.5/Uploader.swf')}}',
            server: "{{url('cdn/upload?_token='.csrf_token())}}",
            pick: '#videoPicker',
            fileVal: 'upload_file',
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader2.on('uploadSuccess', function (file, response) {
            $('input[name="online_service_self[qr_code]"]').val(response.data.url);
            $('.course_paid_success_banner').attr('src', response.data.url);
        });


    });


</script>