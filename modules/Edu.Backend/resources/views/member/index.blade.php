{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/css/formValidation.min.css') !!}


<div class="tabs-container">

    {{--<ul class="nav nav-tabs">--}}
        {{--<li class="{{ Active::query('status','') }}"><a href="" no-pjax> 学员管理--}}
                {{--<span class="badge"></span></a></li>--}}

        {{--<button class="btn btn-info btn-sm pull-right mhs" id="student-add-btn" data-toggle="modal"--}}
                {{--data-target="#modal" data-url="{{route('edu.course.member.create',['id'=>$course->id])}}"><i--}}
                    {{--class="glyphicon glyphicon-plus"></i> 添加学员--}}
        {{--</button>--}}
    {{--</ul>--}}



    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">

            <div class="panel-body">

                <button class="btn btn-info btn-sm pull-right mhs" id="student-add-btn" data-toggle="modal"
                        data-target="#modal" data-url="{{route('edu.course.member.create',['id'=>$course->id])}}">
                    添加学员
                </button>

                <div class="hr-line-dashed" style="opacity: 0"></div>

                <div class="table-responsive">

                    @if(count($students)>0)
                        <table class="table table-hover table-striped" id="course-table">
                            <tbody>
                            <!--tr-th start-->
                            <tr>
                                <th>学员</th>
                                <th>头像</th>
                                <th>加入时间</th>
                                <th>操作</th>
                            </tr>
                            <!--tr-th end-->
                            @foreach ($students as $student)
                                <tr>
                                    <td>
                                        <a target="_blank" href="{{$student->user->link}}">{{$student->user->nick_name}}</a>
                                    </td>
                                    <td>
                                        <a class="user-link user-avatar-link pull-left" href="{{$student->user->link}}">
                                            <img width="40" height="40" src="{{$student->user->avatar}}">
                                        </a>
                                    </td>
                                    <td>
                                        {{date_friendly($student->created_at)}}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-sm"
                                               href="javascript:;">管理</a>
                                            <a href="#" type="button" class="btn btn-default btn-sm dropdown-toggle"
                                               data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-right">

                                                <li><a class="student-remove" href="javascript:;"
                                                       data-url="{{route('edu.course.member.remove',['id'=>$student->course_id,'memberId'=>$student->id])}}">移除</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7" class="footable-visible">
                                    {!! $students->appends(request()->except('page'))->render() !!}
                                </td>
                            </tr>
                            </tfoot>
                            @else
                                <div>
                                    &nbsp;&nbsp;&nbsp;当前无数据
                                </div>
                    @endif
                        </table>

                </div>
            </div>
        </div>
    </div>
</div>


{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/js/formValidation.js') !!}

{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/js/framework/bootstrap.js') !!}

{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/formvalidation/dist/js/language/zh_CN.js') !!}

{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/jquery.form.min.js') !!}


<div id="modal" class="modal inmodal fade"></div>

<script>
    $("#course-table").on('click', '.student-remove', function (e) {
        var $btn = $(e.currentTarget);
        var url = $(this).data('url') + "?_token=" + $('meta[name="_token"]').attr('content');
        swal({
            title: "您真的要移除该学员吗?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            cancelButtonText: '取消',
            closeOnConfirm: false
        }, function () {
            $.post(url, function (response) {
                swal("已删除!", "学员移除成功", "success");
                window.location.href=""
            }, 'json');
        });
    });
</script>
