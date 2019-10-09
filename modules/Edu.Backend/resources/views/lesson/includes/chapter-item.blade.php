<li class="item-chapter clearfix" id="chapter-{{ $item->id }}">
    <div class="item-content">章节 <span class="number">{{ $item->number }}</span>： {{ $item->title }}</div>
    <div class="item-actions pull-right">

        <button class="btn btn-link" title="编辑" data-toggle="modal" data-target="#modal"
                data-keyboard="false"
                data-url="{{route('edu.course.chapter.edit',['chapterId'=>$item->id])}}">
            <i class="glyphicon glyphicon-edit"></i>
        </button>

        <button class="btn btn-link delete-chapter-btn" title="删除"
                data-url="{{route('edu.course.chapter.delete',['id'=>$item->id])}}">
            <i class="glyphicon glyphicon-trash"></i>
        </button>
    </div>
</li>