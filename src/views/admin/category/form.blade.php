<div class="top-bar">
    <h5 class="nav-title">分类编辑</h5>
</div>

<div class="imain">
    <form method="post" @if($res['info']->id) action="/common_admin/category/save?id={{$res['info']->id}}" @else action="/common_admin/category/save" @endif class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="form_edit" class="form-control" value="1">
            @if(!empty($res['parent_info']))
            <div class="form-group">
                <label for="">父级分类</label>
                <input type="text" class="form-control" value="{{$res['parent_info']->name}}" disabled>
            </div>
            @endif
            <div class="form-group">
                <label for="">类型</label>
                <select name="is_leaf" id="is_leaf" class="form-control" disabled>
                    @if($res['info']->is_leaf)
                        <option value="1">子分类</option>
                    @else
                        <option value="0">目录</option>
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">图标 class</label>
                <input type="text" name="icon" class="form-control " value="{{$res['info']->icon}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="text" name="sort" class="form-control " value="{{$res['info']->sort??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">meta_title</label>
                <input type="text" name="meta_title" class="form-control " value="{{$res['info']->meta_title}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">meta_description</label>
                <textarea name="meta_description" rows="4" class="form-control ">{{$res['info']->meta_description}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

