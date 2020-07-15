<li class="item-lesson clearfix" id="lesson-{{ $item->id }}">
    <div class="item-line"></div>
    <div class="item-content">

        @if($item->type == 'video')
            <span class="glyphicon glyphicon-facetime-video text-success"></span>
        @elseif($item->type == 'audio')
            <span class="glyphicon glyphicon-volume-up text-success"></span>
        @elseif($item->type == 'testpaper')
            <span class="glyphicon glyphicon-check text-success"></span>
        @else
            <span class="glyphicon glyphicon-file text-success"></span>
        @endif
        课时 <span class="number">{{ $item->number }}</span>： {{ $item->title }}
        @if($item->free)
            <span class="label label-success mrm">免费</span>
        @endif
        @if(in_array($item->type,['video', 'audio']))
            <span class="text-muted">{{duration($item->length)}}</span>
        @endif
        @if($item->status == 0)
            <span class="text-warning">(未发布)</span>
        @endif


    </div>

    <div class="item-actions">
        {{--@if($item->type == 'testpaper')
            <a class="btn btn-link" title="预览" href=""
               target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
        @else
            <a class="btn btn-link" title="预览"
               href="" target="_blank"><span
                        class="glyphicon glyphicon-eye-open"></span></a>
        @endif--}}

        @if($item->status == 0)
            <button class="btn btn-link publish-lesson-btn" title="发布"
                    data-url="{{route('edu.course.lesson.publish',['id'=>$item->id])}}"><span
                        class="glyphicon glyphicon-ok-circle"></span></button>
        @else
            <button class="btn btn-link unpublish-lesson-btn" title="取消发布"
                    data-url="{{route('edu.course.lesson.unpublish',['id'=>$item->id])}}"><span
                        class="glyphicon glyphicon-remove-circle"></span></button>
        @endif

        <button class="btn btn-link" title="编辑" data-toggle="modal" data-target="#modal" data-backdrop="static"
                data-keyboard="false"
                data-url="{{route('edu.course.lesson.edit',['courseId'=>$item->course_id,'lessonId'=>$item->id])}}">
            <i class="glyphicon glyphicon-edit"></i></button>

        <button class="btn btn-link delete-lesson-btn" title="删除"
                data-url="{{route('edu.course.lesson.delete',$item->id)}}"><span
                    class="glyphicon glyphicon-trash"></span></button>

    </div>
</li>