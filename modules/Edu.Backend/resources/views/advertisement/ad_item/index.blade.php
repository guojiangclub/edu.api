<div class="ibox float-e-margins">
    <div class="ibox-content" style="display: block;">

        <a href="{{ route('edu.ad.item.create',['ad_id'=>request('ad_id')])}}" class="btn btn-primary margin-bottom">添加推广</a>

        <div>

            <div class="box-body table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                    <!--tr-th start-->
                    <tr>
                        <th>推广名称</th>
                        <th>图片</th>
                        <th>链接</th>
                        <th>排序(越小越靠前)</th>
                        <th>操作</th>
                    </tr>
                    <!--tr-th end-->
                    @if(count($ad_items)>0)
                        @foreach ($ad_items as $item)
                            <tr>
                                <td>{{$item->name}}</td>

                                <td>
                                    @if(!empty($item->image))
                                        <img src="{{$item->image}}" style="max-width: 80px;max-height: 80px;"/>
                                    @else
                                        无
                                    @endif
                                </td>

                                <td>{{$item->link}}</td>
                                <td>{{$item->sort}}</td>
                                <td>
                                    <a
                                            class="btn btn-xs btn-primary"
                                            href="{{route('edu.ad.item.edit',['id'=>$item->id,'ad_id'=>$item->advert_id])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-pencil-square-o"
                                           title="编辑"></i></a>
                                    <a  class="btn btn-xs btn-danger item-delete"
                                       data-href="{{route('edu.ad.item.destroy',['id'=>$item->id])}}">
                                        <i data-toggle="tooltip" data-placement="top"
                                           class="fa fa-trash"
                                           title="删除"></i></a>
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
            </div>
        </div>

    </div>

</div>


<script>
    $('.item-delete').on('click', function () {
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
        $.post("{{route('admin.ad.item.toggleStatus')}}",
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