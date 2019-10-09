@extends('edu-backend::layouts.bootstrap_modal')

@section('modal_class')
    modal-lg
@stop

@section('title')
    {{ isset($chapter) ? '编辑' : '添加' }}章节
@stop

@section('body')
    <form id="course-chapter-form" class="form-horizontal" method="post"
          action="{{route('edu.course.chapter.store',['courseId'=>$courseId])}}">
        {{csrf_field()}}
        <input type="hidden" name="chapterId" value="{{ !empty($chapter) ? $chapter->id : '' }}">
        <div class="row form-group">
            <div class="col-md-3 control-label"><label for="chapter-title-field">章节标题</label></div>
            <div class="col-md-8 controls"><input id="chapter-title-field" type="text" name="title"
                                                  value="{{ !empty($chapter) ? $chapter->title : '' }}" class="form-control"></div>
        </div>
    </form>
@stop

@section('footer')
    <button type="button" class="btn btn-link" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary" data-toggle="form-submit" data-target="#course-chapter-form">保存
    </button>

    <script>
        $(function () {
            $('#course-chapter-form').submit(function() {
                // submit the form
                //$(this).ajaxSubmit();

                $.post($("#course-chapter-form").attr('action'), $("#course-chapter-form").serialize(), function(html) {
                    var id = '#' + $(html).attr('id'),
                        $item = $(id);
                    if ($item.length) {
                        $item.replaceWith(html);
                        /* Notify.success('章节信息已保存');*/
                    } else {
                        $("#course-item-list").append(html);
                        /* Notify.success('章节添加成功');*/
                    }
                    $(id).find('.btn-link').tooltip();
                    $("#course-chapter-form").parents('.modal').modal('hide');
                });

                // return false to prevent normal browser submit and page navigation
                return false;
            });



        })
    </script>
@stop

