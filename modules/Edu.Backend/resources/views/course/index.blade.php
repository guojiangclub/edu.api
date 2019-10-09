<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="{{ Active::query('status','')}} {{ Active::query('status','published')}}">
            <a href="{{route('edu.course.list')}}"
               no-pjax> 已发布课程</a>
        </li>
        <li class="{{ Active::query('status','draft') }}">
            <a href="{{route('edu.course.list',['status'=>'draft'])}}"
               no-pjax> 待发布课程</a>
        </li>
        <li class="{{ Active::query('status','closed') }}">
            <a href="{{route('edu.course.list',['status'=>'closed'])}}">
                已关闭课程</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                {!! Form::open( [ 'route' => ['edu.course.list'], 'method' => 'get', 'id' => 'commentsurch-form','class'=>'form-horizontal'] ) !!}
                <input type="hidden" name="status" value="{{!empty(request('status'))?request('status'):''}}">
                <div class="row">
                    <div class="col-sm-3">
                        <select class="form-control" name="category_id">
                            <option value="">课程分类</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select class="form-control" name="recommended">
                            <option value="">推荐状态</option>
                            <option value="recommended" {{request('recommended')=='recommended'?'selected':''}}>已推荐
                            </option>
                            <option value="unrecommended" {{request('recommended')=='unrecommended'?'selected':''}}>
                                未推荐
                            </option>
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="title" value="{{request('title')}}" placeholder="请输入课程名称"
                                   class=" form-control"> <span
                                    class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">查找</button></span></div>
                    </div>

                    <div class="col-sm-2">
                        <div class="btn-group">
                            <a class="btn btn-primary " href="{{ route('edu.course.create') }}" no-pjax>添加课程</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

                <div class="hr-line-dashed"></div>
                <div class="table-responsive" style="min-height:1000px; ">
                    @if(count($courses)>0)
                        <table class="table table-hover table-striped" id="course-table">
                            <tbody>
                            <!--tr-th start-->
                            <tr>
                                <th>编号</th>
                                <th>课程名称</th>
                                <th>学员数</th>
                                <th>收入(元)</th>
                                <th>讲师</th>
                                <th>推荐状态</th>
                                <th>操作</th>
                            </tr>
                            <!--tr-th end-->
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{$course->id}}</td>
                                    <td>
                                        {{$course->title}}
                                    </td>
                                    <td>{{$course->student_count}}</td>
                                    <td>{{$course->income/100}}</td>
                                    <td>{{$course->teacher->name}}</td>
                                    <td>
                                        @if(!$course->recommended)
                                            <label class="label label-danger">未推荐</label>
                                        @else
                                            <label class="label label-success">已推荐</label>
                                    @endif
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-default btn-sm"
                                               href="javascript:;">管理</a>
                                            <a href="#" type="button" class="btn btn-default btn-sm dropdown-toggle"
                                               data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <li>
                                                    @if($course->recommended)
                                                        <a class="cancel-recommend-course" href="javascript:;"
                                                           data-url="{{route('edu.course.switchRecommend',['id'=>$course->id])}}"><span
                                                                    class="glyphicon glyphicon-hand-down"></span>
                                                            取消推荐</a>

                                                    @else
                                                        <a class="recommend-course" href="javascript:;"
                                                           data-url="{{route('edu.course.switchRecommend',['id'=>$course->id])}}"><span
                                                                    class="glyphicon glyphicon-hand-up"></span> 推荐课程</a>
                                                    @endif
                                                </li>
                                                <li>

                                                     <a  href="{{route('edu.course.edit',['id'=>$course->id])}}"
                                                           data-url=""><span
                                                                    class="glyphicon glyphicon-edit"></span> 课程编辑</a>

                                                </li>

                                                <li>

                                                    <a  href="{{route('edu.course.lesson.index',['id'=>$course->id])}}"
                                                        data-url=""><span
                                                                class="glyphicon glyphicon-expand"></span> 课时管理</a>

                                                </li>

                                                <li>

                                                    <a  href="{{route('edu.course.member.index',['id'=>$course->id])}}"
                                                        data-url=""><span
                                                                class="glyphicon glyphicon-user"></span> 学员管理</a>

                                                </li>

                                                {{--<li>--}}
                                                    {{--<a href="https://edu.hellobi.com/course/{{$course->id}}?previewAs=guest"--}}
                                                       {{--target="_blank"><span--}}
                                                                {{--class="glyphicon glyphicon-eye-open"></span> 预览：作为未购买用户</a>--}}
                                                {{--</li>--}}
                                                {{--<li>--}}
                                                    {{--<a href="https://edu.hellobi.com/course/{{$course->id}}?previewAs=member"--}}
                                                       {{--target="_blank"><span--}}
                                                                {{--class="glyphicon glyphicon-eye-open"></span> 预览：作为已购买用户</a>--}}
                                                {{--</li>--}}

                                                <li class="divider"></li>

                                                <li>
                                                    @if($course->status=='closed'|| $course->status=='draft')
                                                        <a class="publish-course" href="javascript:"
                                                           data-url="{{route('edu.course.switchStatus',['id'=>$course->id])}}"><span
                                                                    class="glyphicon glyphicon-ok-circle"></span> 发布课程</a>
                                                    @else
                                                        <a class="close-course" href="javascript:"
                                                           data-url="{{route('edu.course.switchStatus',['id'=>$course->id])}}"><span
                                                                    class="glyphicon glyphicon-ban-circle"></span> 关闭课程</a>
                                                    @endif

                                                </li>
                                                <li class="divider"></li>
                                                {{--<li><a target="_blank"--}}
                                                       {{--href="#"><span--}}
                                                                {{--class="glyphicon glyphicon-ok-circle"></span>--}}
                                                        {{--导出学员</a>--}}
                                                {{--</li>--}}

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="7" class="footable-visible">
                                    {!! $courses->appends(request()->except('page'))->render() !!}
                                </td>
                            </tr>
                            </tfoot>
                            @else
                                <div>
                                    &nbsp;&nbsp;&nbsp;当前无数据
                                </div>
                            @endif
                        </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</div>

@include('edu-backend::course.includes.script')