<div class="ibox float-e-margins">
    <div class="ibox-content" style="display: block;">

        <a href="{{ route('edu.category.create',['group_id'=>$group_id]) }}" class="btn btn-primary margin-bottom"
           no-pjax>添加{{$title}}</a>

        <div class="hr-line-dashed"></div>

        <div>
            <div class="box-header with-border">
                <h3 class="box-title">{{$title}}列表</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-hover table-bordered">
                    <tbody>
                    <!--tr-th start-->
                    <tr>
                        <th>名称</th>
                        <th>排序</th>
                        <th>操作</th>
                    </tr>
                    <!--tr-th end-->

                    @foreach ($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>{{$category->weight}}</td>
                            <td>
                                <a
                                        class="btn btn-xs btn-primary"
                                        href="{{route('edu.category.edit',['id'=>$category->id])}}" no-pjax>
                                    <i data-toggle="tooltip" data-placement="top"
                                       class="fa fa-pencil-square-o"
                                       title="编辑"></i></a>
                                <a class="btn btn-xs btn-danger del-model" href="javascript:;"
                                   data-href="{{route('edu.category.delete',['id'=>$category->id])}}">
                                    <i data-toggle="tooltip" data-placement="top"
                                       class="fa fa-trash"
                                       title="删除"></i></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                {!! $categories->appends(request()->except('page'))->render() !!}
            </div>
        </div>
    </div>
</div>


<script>
    $(function () {
        $('.del-model').on('click', function () {
            var that = $(this);
            var url = that.data('href') + "?_token=" + _token;

            swal({
                title: "您真的要删除吗?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认",
                cancelButtonText: '取消',
                closeOnConfirm: false
            }, function () {
                $.post(url, function (ret) {
                    if (ret.status) {
                        swal({
                            title: "删除成功！",
                            text: "",
                            type: "success"
                        }, function () {
                            location.reload();
                        });
                    } else {
                        swal({
                            title: ret.message,
                            text: "",
                            type: "warning"
                        }, function () {

                        });

                    }
                });
            });


        });
    });
</script>