
<div class="top-bar">
    <h5 class="nav-title">group</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/common_admin/group/save?id={{$res['info']->id}}" @else action="/common_admin/group/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">价格</label>
                <input type="number" name="price" class="form-control " value="{{$res['info']->price??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['info']->sort??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>

</style>
<script>

</script>
