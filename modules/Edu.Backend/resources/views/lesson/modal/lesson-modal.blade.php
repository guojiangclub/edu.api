@extends('edu-backend::layouts.bootstrap_modal')

@section('title')
    {{ !empty($lesson) ? '编辑课时'.$lesson->number : '添加课时' }}
@stop
@section('modal_class')
    modal-lg
@stop

@section('body')
    <form id="course-lesson-form" class="form-horizontal lesson-form" method="post"
          action="{{route('edu.course.lesson.store',['courseId'=>$courseId])}}">
        {{csrf_field()}}
        <input type="hidden" name="lessonId" value="{{ !empty($lesson) ? $lesson->id : '' }}">
        <input type="hidden" name="type" value="video">
        {{--<input type="hidden" name="mediaSource" value="aliyun">--}}
        <div class="form-group">
            <div class="col-md-2 control-label"><label for="lesson-title-field">标题 <span
                            class="required"></span></label></div>
            <div class="col-md-9 controls">
                <div class="row">
                    <div class="col-md-9">
                        <input id="lesson-title-field" class="form-control" type="text" name="title"
                               value="{{ !empty($lesson) ? $lesson->title : '' }}"
                               data-widget-cid="widget-29" data-explain="">
                    </div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <input type="hidden" value="0" name="free">
                            <label><input type="checkbox" name="free" {{(!empty($lesson) AND $lesson->free)?'checked':''}} value="1">
                                免费课时</label>
                        </div>
                    </div>
                </div>
                <div class="help-block" style=""><span class="text-danger"></span></div>
            </div>
        </div>

        <div class="form-group for-video-type for-audio-type">
            <div class="col-md-2 control-label"><label for="lesson-summary-field">摘要</label></div>
            <div class="col-md-9 controls"><textarea class="form-control" id="lesson-summary-field"
                                                     name="summary">{{ !empty($lesson) ? $lesson->summary : '' }}</textarea>
                <div class="help-block" style="display:none;"></div>
            </div>
        </div>

        {{--<div class="form-group for-video-type for-audio-type">--}}
            {{--<div class="col-md-2 control-label for-video-type"><label>视频 <span--}}
                            {{--class="required"></span></label></div>--}}
            {{--<div class="col-md-9 controls">--}}
                {{--<input id="lesson-title-field" class="form-control" type="text" name="mediaUri"--}}
                       {{--value="{{ !empty($lesson) ? $lesson->mediaUri : '' }}"--}}
                       {{--placeholder="请输入阿里云OSS资源链接或者直播资源地址">--}}
                {{--<div class="help-block" style="display:none;"></div>--}}
            {{--</div>--}}

        {{--</div>--}}

        <div class="form-group for-video-type for-audio-type">
            <div class="col-md-2 control-label for-video-type"><label>videoId<span
                            class="required"></span></label></div>
            <div class="col-md-9 controls">
                <input id="lesson-title-field" class="form-control" type="text" name="media_id"
                       value="{{ !empty($lesson) ? $lesson->media_id : '' }}"
                       placeholder="请输入阿里云视频videoId">
                <div class="help-block" style="display:none;"></div>
            </div>

        </div>

        {{--<div class="form-group for-video-type for-audio-type">--}}
            {{--<div class="col-md-2 control-label for-video-type"><label>直播讨论ID <span--}}
                            {{--class=""></span></label></div>--}}
            {{--<div class="col-md-9 controls">--}}
                {{--<input id="lesson-title-field" class="form-control" type="text" name="tis_id"--}}
                       {{--value="{{ !empty($lesson) ? $lesson->tis_id : '' }}"--}}
                       {{--placeholder="">--}}
                {{--<div class="help-block" style="display:none;"></div>--}}
            {{--</div>--}}

        {{--</div>--}}
        <div class="form-group for-video-type for-audio-type" id="lesson-length-form-group">
            <div class="col-md-2 control-label for-video-type"><label>视频时长 <span
                            class="required"></span></label></div>
            <div class="col-md-9 controls">
                <input class="form-control width-input width-input-small" id="lesson-minute-field" type="text"
                       name="minute" value="{{ !empty($lesson) ? secondsToText($lesson->length)[0] : '' }}"
                       data-widget-cid="widget-38" data-explain="时长必须为整数。">分
                <input class="form-control width-input width-input-small" id="lesson-second-field" type="text"
                       name="second" value="{{ !empty($lesson) ?  secondsToText($lesson->length)[1] : '' }}"
                       data-widget-cid="widget-37"
                       data-explain="时长必须为整数。">秒
                <div class="help-block">时长必须为整数。</div>
            </div>
        </div>
    </form>
@stop

@section('footer')
    <button type="button" class="btn btn-link" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary" data-toggle="form-submit" data-target="#course-lesson-form">保存
    </button>

    <script>
        $('#course-lesson-form').find("input").iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
            increaseArea: '20%'
        });
        $(function () {
            $('#course-lesson-form').formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    title: {
                        validators: {
                            notEmpty: {
                                message: '请输入课时名称'
                            }
                        }
                    },
                    mediaUri: {
                        validators: {
                            notEmpty: {
                                message: '请输入阿里云OSS资源链接或者直播资源地址'
                            },
                            uri: {
                                message: '请输入有效的URL'
                            }
                        }
                    },
                    minute: {
                        validators: {
                            notEmpty: {
                                message: '请输入视频时间'
                            }
                        }
                    }
                }
            }).on('success.form.fv', function (e) {
                // Prevent form submission
                e.preventDefault();

                var $panel = $('.lesson-manage-panel');
                $.post($("#course-lesson-form").attr('action'), $("#course-lesson-form").serialize(), function (html) {
                    var id = '#' + $(html).attr('id'),
                        $item = $(id);
                    if ($item.length) {
                        $item.replaceWith(html);
                        /* Notify.success('章节信息已保存');*/
                    } else {
                        $panel.find('.empty').remove();
                        $("#course-item-list").append(html);
                        /* Notify.success('章节添加成功');*/
                    }
                    $(id).find('.btn-link').tooltip();
                    $("#course-lesson-form").parents('.modal').modal('hide');
                });
            });


        })
    </script>
@stop

