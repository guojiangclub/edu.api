<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="{{ Active::query('status','') }}">
            <a href="{{route('edu.svip.plan.list')}}"
               no-pjax> 进行中</a>
        </li>
        <li class="{{ Active::query('status','invalid') }}">
            <a href="{{route('edu.svip.plan.list',['status'=>'invalid'])}}"
               no-pjax> 已失效</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <div class="panel-body">
                {!! Form::open( [ 'route' => ['edu.svip.plan.list'], 'method' => 'get', 'id' => 'commentsurch-form','class'=>'form-horizontal'] ) !!}
                <input type="hidden" name="status" value="{{!empty(request('status'))?request('status'):''}}">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" name="title" value="{{request('title')}}" placeholder="请输入VIP计划名称搜索"
                                   class=" form-control"> <span
                                    class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">查找</button></span></div>
                    </div>

                    <div class="col-sm-2">
                        <div class="btn-group">
                            <a class="btn btn-primary" href="{{ route('edu.svip.plan.create') }}" no-pjax>添加VIP计划</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

                <div class="hr-line-dashed"></div>

                <div class="table-responsive">
                    @if(count($plans)>0)
                        <table class="table table-hover table-striped" id="course-table">
                            <tbody>
                            <!--tr-th start-->
                            <tr>
                                <th>名称</th>
                                <th>价格(元)</th>
                                <th>有效期</th>
                                <th>学员数</th>
                                <th>促销状态</th>
                                <th>操作</th>
                            </tr>
                            <!--tr-th end-->
                            @foreach ($plans as $plan)
                                <tr>
                                    <td>{{$plan->title}}</td>
                                    <td>
                                        {{$plan->price}}
                                    </td>
                                    <td>{{$plan->days}}天</td>
                                    <td>{{$plan->member_count}}</td>
                                    <td>
                                        @if($plan->is_discount)
                                            <label class="label label-danger">促销中</label>
                                        @endif
                                    <td>
                                        <a
                                                class="btn btn-xs btn-primary"
                                                href="{{route('edu.svip.plan.edit',['id'=>$plan->id])}}" no-pjax>
                                            <i data-toggle="tooltip" data-placement="top"
                                               class="fa fa-pencil-square-o"
                                               title="编辑"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6" class="footable-visible">
                                    {!! $plans->appends(request()->except('page'))->render() !!}
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