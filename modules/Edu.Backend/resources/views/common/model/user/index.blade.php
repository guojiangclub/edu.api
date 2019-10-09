@extends('edu-backend::common.model.bootstrap_modal')

@section('modal_class')
    modal-lg
@stop
@section('title')
添加教师
@stop

@section('after-styles-end')
    {!! Html::style(env("APP_URL").'/assets/edu-backend/libs/pager/css/kkpager.css') !!}
@stop

@section('body')

    <br>
    <div class="row">
        <form class="form-horizontal" action="{{route('edu.common.users.model.list')}}" method="get" id="search_from">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
                    <div class="col-md-3">
                        <select class="form-control" name="field" id="select">
                            <option value="user_name" {{request('field')=='user_name'?'selected':''}} >用户名</option>
                            <option value="mobile" {{request('field')=='mobile'?'selected':''}} >手机</option>
                            <option value="email" {{request('field')=='email'?'selected':'email'}} >邮箱</option>
                        </select>
                    </div>

                    <div class="col-md-5">
                        <div class="input-group col-md-12">
                            <input type="text" name="value" value="{{request('value')}}" placeholder=""
                                   class=" form-control">

                        </div>
                    </div>

                    <div class="col-sm-2">
                        <button type="submit" id="" class="ladda-button btn btn-primary" data-style="slide-right"
                        >搜索
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="clearfix"></div>
        <div class="hr-line-dashed "></div>

        <div class="panel-body">
            <div class="col-sm-2">

            </div>
            <div class="table-responsive col-sm-9" id="List">

            </div>

            <div class="col-sm-1">

            </div>

        </div>
    </div>
@stop


@section('footer')
    {{--<button type="button" class="btn btn-link cancel" data-dismiss="modal">取消</button>--}}
    {{--<button type="button" class="ladda-button btn btn-primary" id="sendIds">确定</button>--}}
@endsection



@section('after-script-end')
    {!! Html::script(env("APP_URL").'/assets/edu-backend/libs/jquery.form.min.js') !!}
    {!! Html::script(env("APP_URL").'/assets/edu-backend/libs/alpaca-spa-2.1.js') !!}
    {!! Html::script(env("APP_URL").'/assets/edu-backend/libs/pager/js/kkpager.js') !!}
    <script>
        $(function () {
            $.get('{{route('edu.common.users.model.list')}}',function (ret) {
                $('#List').html(ret);
            });
            //搜索
            $('#search_from').ajaxForm({
                success: function (result) {
                    console.log(result);
                    $('#List').html(result);
                }
            });
        })
    </script>
@endsection












