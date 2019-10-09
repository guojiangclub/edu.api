<script type="text/javascript">
    $(function () {
        var $table = $('#course-table');

        $table.on('click', '.close-course', function () {

            var url = $(this).data('url') + "?_token=" + $('meta[name="_token"]').attr('content');

            swal({
                title: "您真的要关闭该课程吗?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "关闭",
                cancelButtonText: '取消',
                closeOnConfirm: false
            }, function () {
                $.post(url, function (html) {
                    var $tr = $(html);
                    $table.find('#' + $tr.attr('id')).replaceWith(html);
                    swal({
                        title: "课程关闭成功!",
                        text: "",
                        type: "success"
                    }, function () {
                        location.reload();
                    });
                });
            });
        });

        $table.on('click', '.publish-course', function () {
            var url = $(this).data('url') + "?_token=" + $('meta[name="_token"]').attr('content');
            swal({
                title: "您确认要发布此课程吗?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "发布",
                cancelButtonText: '取消',
                closeOnConfirm: false
            }, function () {
                $.post(url, function (html) {
                    var $tr = $(html);
                    $table.find('#' + $tr.attr('id')).replaceWith(html);
                    swal({
                        title: "课程发布成功!",
                        text: "",
                        type: "success"
                    }, function () {
                        location.reload();
                    });
                });
            });
        });

        $table.on('click', '.cancel-recommend-course', function () {
            var url = $(this).data('url') + "?_token=" + _token;
            swal({
                title: "您确认取消推荐此课程吗?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: '取消',
                closeOnConfirm: false
            }, function () {
                $.post(url, function (html) {
                    var $tr = $(html);
                    $table.find('#' + $tr.attr('id')).replaceWith(html);
                    swal({
                        title: "取消推荐成功!",
                        text: "",
                        type: "success"
                    }, function () {
                        location.reload();
                    });
                });
            });
        });
        $table.on('click', '.recommend-course', function () {
            var url = $(this).data('url') + "?_token=" + _token;
            swal({
                title: "您确认推荐此课程吗?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                cancelButtonText: '取消',
                closeOnConfirm: false
            }, function () {
                $.post(url, function (html) {
                    var $tr = $(html);
                    $table.find('#' + $tr.attr('id')).replaceWith(html);
                    swal({
                        title: "推荐成功!",
                        text: "",
                        type: "success"
                    }, function () {
                        location.reload();
                    });
                });
            });
        });

    });
</script>