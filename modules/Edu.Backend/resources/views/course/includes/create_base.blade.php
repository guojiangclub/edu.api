<div class="form-group">
    <label class="col-sm-2 control-label">课程标题：</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="title" placeholder="">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">副标题：</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="subtitle" placeholder="">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">学员有效期：</label>
    <div class="col-sm-10">
        <div class="input-group m-b">
            <input class="form-control number_valid"
                   name="expiry_day" type="text" value="365"> <span
                    class="input-group-addon">天</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">课程形式：</label>
    <div class="col-sm-10">
        <select class="form-control" id="course-xingshi" name="courseShapes[]" multiple>
            @foreach($categories as $category)
                @if($category->groupId==2)
                    <option value="{{$category->id}}">{!! $category->name !!}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">课程方向：</label>
    <div class="col-sm-10">
        <select class="form-control" id="course-category" name="courseCategories[]" multiple>
            @foreach($categories as $category)
                @if($category->groupId==1)
                    <option value="{{$category->id}}">{!! $category->name !!}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">课程标签：</label>
    <div class="col-sm-10">
        <select class="form-control" id="course-tag" name="courseTags[]" multiple>
            @foreach($categories as $category)
                @if($category->groupId==3)
                    <option value="{{$category->id}}">{!! $category->name !!}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">课程图片：</label>
    <div class="col-sm-10">
        <input type="hidden" name="picture" src="https://cdn.hellobi.com/images/default/course-default-475x250.png">
        <img class="courseImg" width="480" height="270"
             src="https://cdn.hellobi.com/images/default/course-default-475x250.png">
        <div id="coursePicker">选择图片</div>
        <div class="clearfix"></div>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">教师设置：</label>
    <div class="col-sm-10">
        <ul class="list-group teacher-list-group sortable-list" data-role="list" style="" id="teacher-content">
            {{--<li class="list-group-item clearfix" data-role="item" data-id="10">--}}
                {{--<span class="glyphicon glyphicon-resize-vertical sort-handle"></span>--}}
                {{--<img src="https://ask.hellobi.com/uploads/avatar/000/00/00/10_avatar_max.jpg" class="avatar-small">--}}
                {{--<span class="nickname">子呆不呆</span>--}}
                {{--<button class="close delete-btn" data-role="item-delete" type="button" title="删除">×</button>--}}
            {{--</li>--}}

        </ul>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
        <a class="btn btn-primary margin-bottom" data-toggle="modal"
             data-target="#users_modal" data-backdrop="static" data-keyboard="false"
             data-url="{{route('edu.common.users.model')}}">
            添加教师
        </a>
    </div>
</div>


<div id="users_modal" class="modal inmodal fade"></div>

<script>
    var data = {
        result:[]
    };
</script>


<script id='teacher-template' type="text">

    @{{ for (var item in it.result) { }}

    <li class="list-group-item clearfix teacher_ids@{{=it.result[item]['id']}}" data-role="item" data-id="@{{=it.result[item]['id']}}">

                            <img src="@{{=it.result[item]['avatar']}}" class="avatar-small">
                            <span class="nickname">@{{=it.result[item]['nick_name']}}</span>
                            <button class="close delete-btn" data-role="item-delete" type="button" onclick="del(@{{=it.result[item]['id']}})"  title="删除">×</button>
               </li>
               <input class="teacher_ids@{{=it.result[item]['id']}}"  type="hidden" name="ids[]" value="@{{=it.result[item]['id']}}">

    @{{ } }}
</script>

<script>
    function del(id) {
        if(data.result.length){
            for(k in data.result){
                if(data.result[k]['id']==id){
                    data.result.splice(k, 1)
                }
            }
        }
        $('.teacher_ids'+id).remove();
    }
</script>




{{--<ul id="mylist" style="display: none;">--}}
    {{--<li data-id="6" data-avatar="/uploads/avatar/6/enEddkwacC.jpg"--}}
        {{--data-name="梁勇">梁勇</li>--}}
    {{--<li data-id="8" data-avatar="https://ask.hellobi.com/uploads/avatar/000/00/00/08_avatar_max.jpg"--}}
        {{--data-name="gogodiy">gogodiy</li>--}}
    {{--<li data-id="10" data-avatar="https://ask.hellobi.com/uploads/avatar/000/00/00/10_avatar_max.jpg"--}}
        {{--data-name="子呆不呆">子呆不呆</li>--}}
    {{--<li data-id="11" data-avatar="https://ask.hellobi.com/uploads/avatar/000/00/00/11_avatar_max.jpg"--}}
        {{--data-name="冰咖啡">冰咖啡</li>--}}
    {{--<li data-id="16" data-avatar="https://ask.hellobi.com/uploads/avatar/000/00/00/16_avatar_max.jpg"--}}
        {{--data-name="牟瑞">牟瑞</li>--}}
{{--</ul>--}}


