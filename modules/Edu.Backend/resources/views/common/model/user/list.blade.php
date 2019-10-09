{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/pager/css/kkpager.css') !!}

<table class="table table-hover table-striped" id="app">
    <tbody>
    <!--tr-th start-->
    <tr>
        <th>ID</th>
        <th>头像</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>电话</th>
        <th>操作</th>
    </tr>
    <!--tr-th end-->
    @foreach($lists as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>
                <img src="{{$item->avatar}}" alt="" width="50" height="50">
            </td>
            <td>{{$item->user_name}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->mobile}}</td>
            <td>
                <input type="checkbox" class="ids" name="ids"

                       data-info="{{$item}}"

                       id="ids_{{$item->id}}" value="{{$item->id}}">
            </td>

        </tr>
    @endforeach
    </tbody>
</table>

{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/jquery.form.min.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/alpaca-spa-2.1.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/pager/js/kkpager.js') !!}

<div id="kkpager"></div>

<script>
    $('#app').find("input").iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
        increaseArea: '20%'
    });
    //选中
    if(data.result.length){
        for(k in data.result){
            $('#ids_'+data.result[k]['id']).iCheck('check');
        }
    }
    $('input[name=ids]').on('ifChanged', function(e){
        var that=$(this);
        var id=parseInt(that.val());
        var status=false;
        var info=$(this).data('info');
        if(data.result.length){
            for(k in data.result){
                if(data.result[k]['id']==id){
                    var status=true;
                    data.result.splice(k, 1);
                }
            }
        }
        if(!status){
            data.result.push(info)
        }
        $('#teacher-content').empty();
        Alpaca.Tpl({data:data ,from:"#teacher-template", to:"#teacher-content"});
    });

    $(function () {
        function getParameter(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }
        var totalPage = "{{$lists->lastPage()}}";
        var totalRecords = "1";
        var pageNo = getParameter('page');
        if (!pageNo) {
            pageNo = 1;
        }
        kkpager.generPageHtml({
            pno: pageNo,
            //总页码
            total: totalPage,
            //总数据条数
            totalRecords: totalRecords,
            mode: 'click',
            click: function (n) {
                var value=$('input[name=value]').val();
                var data = {};
                if(value){
                    data.value=value;
                    data.field=$('#select option:selected') .val()
                }
                $.get("{{route('edu.common.users.model.list')}}?page=" + n,data,function (res) {
                    $("#List").html("");
                    $("#List").html(res);
                    kkpager.selectPage(n);
                });
            }
        });

    });
</script>


