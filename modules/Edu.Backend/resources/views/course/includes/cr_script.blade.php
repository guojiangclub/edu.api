<script type="text/javascript">
    var ue = UE.getEditor('container', {
        autoHeightEnabled: false,
        initialFrameHeight: 500
    });
    ue.ready(function () {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.

    });

    String.format = function () {
        var s = arguments[0];
        for (var i = 0; i < arguments.length - 1; i++) {
            var reg = new RegExp("\\{" + i + "\\}", "gm");
            s = s.replace(reg, arguments[i + 1]);
        }
        return s;
    };

    $('#two-inputs').dateRangePicker(
            {
                separator: ' to ',
                time: {
                    enabled: true
                },
                language: 'cn',
                format: 'YYYY-MM-DD HH:mm',
                inline: true,
                container: '#date-range12-container',
                startDate: '{{\Carbon\Carbon::now()}}',
                showShortcuts:false,
                getValue: function () {
                    if ($('#date-range200').val() && $('#date-range201').val())
                        return $('#date-range200').val() + ' to ' + $('#date-range201').val();
                    else
                        return '';
                },
                setValue: function (s, s1, s2) {
                    $('#date-range200').val(s1);
                    $('#date-range201').val(s2);
                }
            });

    $(function () {
        var dataShape = [33];
        var shapeSelect  =  $("#course-xingshi").select2();
        shapeSelect.val(dataShape).trigger("change");

        var dataTag = [27,62];
        var tagSelect =  $("#course-tag").select2();
        tagSelect.val(dataTag).trigger("change");

        var dataCategory = [38,39];
        var categorySelect = $("#course-category").select2();
        categorySelect.val(dataCategory).trigger("change");


        var h5logoPicker = WebUploader.create({
            auto: true,
            swf: '{{url(env("APP_URL").'/assets/backend/libs/webuploader-0.1.5/Uploader.swf')}}',
            {{--server: '{{route('file.upload',['_token'=>csrf_token()])}}',--}}
            server:"{{url('cdn/upload?_token='.csrf_token())}}",
            pick: '#coursePicker',
            fileVal: 'upload_file',
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });

        h5logoPicker.on('uploadSuccess', function (file, response) {
            var img_url = response.data.url;
            $('input[name="picture"]').val(img_url);
            $('.courseImg').attr('src', img_url);
        });


        $('[data-role=item-add]').click(
                function () {
                    $value = $('#teacher-input').val();
                    var id = $('[data-name=' + $value + ']').data('id');
                    var avatar = $('[data-name=' + $value + ']').data('avatar');
                    var name = $('[data-name=' + $value + ']').data('name');
                    var error = '';
                    $('input[name="ids[]"]').each(function (i, item) {
                        if (parseInt(id) == parseInt($(item).val())) {
                            error = '该教师已添加，不能重复添加！';
                        }
                    });

                    if (error) {
                        alert(error);
                        return;
                    }

                    var teacherString = $("#teacher-template").html();
                    $('.teacher-list-group').append(String.format(teacherString, avatar, name, id));
                    $('#teacher-input').val('');

                    $('[data-role=item-delete]').click(
                            function () {
                                $(this).parents('[data-role=item]').remove();
                            }
                    );
                }
        );

        // new Awesomplete($('input[data-multiple]'), {
        //     filter: function (text, input) {
        //         return Awesomplete.FILTER_CONTAINS(text, input.match(/[^,]*$/)[0]);
        //     },
        //
        //     replace: function (text) {
        //         var before = this.input.value.match(/^.+,\s*|/)[0];
        //         this.input.value = before + text + ", ";
        //     }
        //
        // });
    });
</script>

<script type="text/html" id="teacher-template">
    <li class="list-group-item clearfix" data-role="item" data-id="{2}">
        <span class="glyphicon glyphicon-resize-vertical sort-handle"></span>
        <img src="{0}" class="avatar-small">
        <span class="nickname">{1}</span>

        <input type="hidden" name="ids[]" value="{2}">
        <button class="close delete-btn" data-role="item-delete" type="button"
                title="删除">&times;</button>
    </li>
</script>


