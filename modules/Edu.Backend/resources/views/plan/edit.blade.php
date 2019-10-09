{!! Html::style(env("APP_URL").'/assets/edu-backend/libs/dategrangepicker/daterangepicker.css') !!}

<div class="tabs-container" id="wizard">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">基本信息<i
                        class="glyphicon"></i></a></li>
        <li><a href="#tab_2" data-toggle="tab"
               aria-expanded="false">促销设置</a></li>
    </ul>

    {!! Form::open( [ 'url' => [route('edu.svip.plan.store')], 'method' => 'POST', 'id' => 'base-form','class'=>'form-horizontal'] ) !!}
    <input type="hidden" name="id" value="{{$plan->id}}">

    <div class="tab-content items">
        <div class="tab-pane active" id="tab_1">
            <div class="panel-body">
                @include('edu-backend::plan.includes.edit_base')
            </div><!-- /.tab-pane -->
        </div>


        <div class="tab-pane" id="tab_2">
            <div class="panel-body">
                @include('edu-backend::plan.includes.edit_discount')
            </div>
        </div>

        <div class="ibox-content m-b-sm border-bottom text-right">
            <input type="submit" class="btn btn-success" data-toggle="form-submit" data-target="#base-form"
                   value="保存">
        </div>


    </div><!-- /.tab-content -->
    {!! Form::close() !!}
</div>

{!! Html::script(env("APP_URL").'/vendor/libs/jquery.form.min.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/dategrangepicker/moment.min.js') !!}
{!! Html::script(env("APP_URL").'/assets/edu-backend/libs/dategrangepicker/jquery.daterangepicker.js') !!}
@include('edu-backend::plan.includes.script')