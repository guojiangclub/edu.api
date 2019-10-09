<script>

    $(function () {
        $(".lesson-manage-panel .panel-heading").sticky({topSpacing: 0});

        var sortable = Sortable.create(document.getElementById('course-item-list'),
            {
                animation: 150,
                // dragging ended
                onEnd: function (/**Event*/evt) {

                    var data = $("#course-item-list").children('li').map(function () {
                        return this.id;
                    }).get();

                    var $list = $("#course-item-list");

                    $.post($list.data('sortUrl'),
                        {
                            ids: data,
                            _token: $('meta[name="_token"]').attr('content')
                        }, function (response) {

                            $list.find('.item-lesson').each(function (index) {
                                $(this).find('.number').text(index + 1);
                            });

                            $list.find('.item-chapter').each(function (index) {
                                $(this).find('.number').text(index + 1);
                            });
                        });
                }
            });

        $("#course-item-list").on('click', '.publish-lesson-btn', function (e) {
            var $btn = $(e.currentTarget);
            $.post($(this).data('url') + "?_token=" + $('meta[name="_token"]').attr('content'), function (html) {
                var id = '#' + $(html).attr('id');
                $(id).replaceWith(html);
                $(id).find('.btn-link').tooltip();
                swal("课时发布成功!", "", "success");
            });
        });

        $("#course-item-list").on('click', '.unpublish-lesson-btn', function (e) {
            console.log(1);
            var $btn = $(e.currentTarget);
            $.post($(this).data('url') + "?_token=" + $('meta[name="_token"]').attr('content'), function (html) {
                var id = '#' + $(html).attr('id');
                $(id).replaceWith(html);
                $(id).find('.btn-link').tooltip();
                swal("课时已取消发布!", "", "success");
            });
        });

        $("#course-item-list").on('click', '.delete-lesson-btn', function (e) {
            /*if (!confirm('删除课时的同时会删除课时的资料、测验。\n您真的要删除该课时吗？')) {
             return;
             }*/
            var $btn = $(e.currentTarget);
            var url = $(this).data('url') + "?_token=" + $('meta[name="_token"]').attr('content');
            swal({
                title: "您真的要删除该课时吗?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "删除",
                cancelButtonText: '取消',
                closeOnConfirm: false
            }, function () {
                $.post(url, function (response) {
                    $btn.parents('.item-lesson').remove();
                    swal("已删除!", "课时已删除", "success");
                }, 'json');
            });
        });

        $("#course-item-list").on('click', '.delete-chapter-btn', function (e) {
            var $btn = $(e.currentTarget);
            var url = $(this).data('url') + "?_token=" + $('meta[name="_token"]').attr('content');
            swal({
                title: "您真的要删除该章节吗?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "删除",
                cancelButtonText: '取消',
                closeOnConfirm: false
            }, function () {
                $.post(url, function (response) {
                    $btn.parents('.item-chapter').remove();
                    swal("已删除!", "章节已删除", "success");
                }, 'json');
            });
        });

        $("#course-item-list .item-actions .btn-link").tooltip();
    });
</script>