@if(Session::has('message'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> 提示！</h4>
        {{ Session::get('message') }}
    </div>
@endif

<div class="ibox float-e-margins">
    <div class="ibox-content" style="display: block;">

{{--        <a href="{{ route('edu.ad.create')}}" class="btn btn-primary margin-bottom" no-pjax>添加推广位</a>--}}

        <div>
            <div class="box-body table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                    <!--tr-th start-->
                    <tr>
                        <th>推广位名称</th>
                        <th>Code编码</th>
                        {{--<th>是否可用</th>--}}
                        <th>操作</th>
                    </tr>
                    <!--tr-th end-->
                    @if(count($advertisement)>0)
                        @foreach ($advertisement as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->code}}</td>
                                <td>
                                    <a
                                            class="btn btn-xs btn-primary"
                                            href="{{route('edu.ad.edit',['id'=>$item->id])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-pencil-square-o"
                                           title="编辑"></i></a>
                                    <a href="{{route('edu.ad.item.index',['ad_id'=>$item->id])}}" data-skin="skin-green"
                                       class="btn btn-success btn-xs" no-pjax>
                                        <i data-toggle="tooltip" data-placement="top" class="fa fa-eye"
                                           title="查看推广"></i></a>
                                    {{--<a class="btn btn-xs btn-danger a-delete"
                                       data-href="{{route('edu.ad.destroy',['id'=>$item->id])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-trash"
                                           title="删除"></i></a>--}}
                                    <a>
                                        <i class="fa switch @if($item->status) fa-toggle-on @else fa-toggle-off @endif"
                                           title="切换状态" value= {{$item->status}} >
                                            <input type="hidden" value={{$item->id}}>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                @if(count($advertisement)>0)
                    <div class="pull-left">
                        &nbsp;&nbsp;共&nbsp;{!!$advertisement->total() !!} 条记录
                    </div>

                    <div class="pull-right">
                        {!!$advertisement->render() !!}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
<script>
    $('.a-delete').on('click', function () {
        var that = $(this);
        $.post(that.data('href'),
            {
                _token: window._token
            },
            function (res) {
                if (res.status) {
                    location.reload();
                } else {
                    swal(res.message, '', 'error')
                }
            });
    });


    $('.switch').on('click', function () {
        var value = $(this).attr('value');
        var modelId = $(this).children('input').attr('value');
        value = parseInt(value);
        modelId = parseInt(modelId);
        value = value ? 0 : 1;
        var that = $(this);
        $.post("{{route('edu.ad.toggleStatus')}}",
            {
                status: value,
                aid: modelId
            },
            function (res) {
                if (res.status) {
                    that.toggleClass("fa-toggle-off , fa-toggle-on");
                    that.attr('value', value);
                }
            });

    })
</script>