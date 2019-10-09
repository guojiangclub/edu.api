{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/css/formValidation.min.css') !!}
<style>
    .panel-col {
        min-height: 400px;
    }

    .panel-col .panel-heading {
        background: transparent;
        font-weight: bold;
        color: #393d4d;
        padding: 20px 20px;
    }

    .mhs {
        margin-left: 5px;
        margin-right: 5px;
    }

    .lesson-list {
        margin: 0 10px 0 40px;
        padding: 0;
        list-style: none;
        border-left: 2px solid #ccc;
    }

    .lesson-list .item-chapter, .lesson-list .item-lesson {
        border: 1px solid #ccc;
        background: #fff;
        line-height: 40px;
        margin-bottom: 15px;
    }

    .lesson-list .item-chapter {
        margin-left: -30px;
    }

    .lesson-list .item-lesson {
        margin-left: 20px;
    }

    .lesson-list .item-content {
        margin-left: 10px;
        overflow: hidden;
        height: 40px;
        line-height: 40px;
        float: left;
    }

    .lesson-list .item-actions {
        visibility: hidden;
        top: 0;
        right: 0;
        background: #f3f3f3;
        border-left: 1px solid #ddd;
        margin-left: 10px;
        float: right;
    }

    .lesson-list .item-line {
        border-bottom: 2px solid #ccc;
        vertical-align: top;
        display: inline-block;
        height: 20px;
        width: 20px;
        margin-left: -21px;
        float: left;
    }

    .lesson-list .item-chapter:hover, .lesson-list .item-lesson:hover {
        background: #f3f3f3;
    }

    .lesson-list .item-chapter:hover .item-actions, .lesson-list .item-lesson:hover .item-actions {
        visibility: visible;
    }
</style>

<div class="panel panel-default panel-col lesson-manage-panel">
    <div class="panel-heading">
        {{--<button class="btn btn-info btn-sm pull-right mhs" id="lesson-create-btn" data-toggle="modal"
                data-target="#modal" data-backdrop="static" data-keyboard="false"
                data-url=""><i
                    class="glyphicon glyphicon-plus"></i> 试卷
        </button>--}}

        <button class="btn btn-info btn-sm pull-right mhs" id="chapter-create-btn" data-toggle="modal"
                data-target="#modal" data-backdrop="static" data-keyboard="false"
                data-url="{{route('edu.course.chapter.create',['courseId'=>$course->id])}}">
            {{--<i class="glyphicon glyphicon-plus"></i> --}}
            添加章节
        </button>

        <button class="btn btn-info btn-sm pull-right mhs" id="lesson-create-btn" data-toggle="modal"
                data-target="#modal" data-backdrop="static" data-keyboard="false"
                data-url="{{route('edu.course.lesson.create',['courseId'=>$course->id])}}">
            {{--<i class="glyphicon glyphicon-plus"></i>--}}
            添加课时
        </button>

        {{$course->title}}
    </div>

    @if(empty($courseItems))
        <div class="empty" style="margin-left: 20px;">暂无课时内容！</div>
    @endif

    <div class="panel-body">
        <ul class="lesson-list sortable-list" id="course-item-list"
            data-sort-url="{{route('edu.course.lesson.sort',['id'=>$course->id])}}">

            @foreach($courseItems as $item )
                @if($item->itemType =='chapter')
                    @include('edu-backend::lesson.includes.chapter-item')
                @else
                    @include('edu-backend::lesson.includes.lesson-item')
                @endif
            @endforeach
        </ul>
    </div>
</div>

<script src="https://cdn.bootcss.com/Sortable/1.8.4/Sortable.min.js"></script>

<script src="https://cdn.bootcss.com/jquery.sticky/1.0.4/jquery.sticky.min.js"></script>

{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/js/formValidation.js') !!}

{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/js/framework/bootstrap.js') !!}

{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/js/language/zh_CN.js') !!}

{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/jquery.form.min.js') !!}

@include('edu-backend::lesson.includes.script')


<div id="modal" class="modal inmodal fade"></div>

