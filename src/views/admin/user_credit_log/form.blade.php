
<div class="top-bar">
    <h5 class="nav-title">user credit log</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/common_admin/user_credit_log/save?id={{$res['info']->id}}" @else action="/common_admin/user_credit_log/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <select name="credit_key" >
                    @foreach($res['credit_key'] as $val)
                    <option value="{{$val}}" @if($res['info']->credit_key==$val) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">数量</label>
                <input type="number" name="credit_val" class="form-control " value="{{$res['info']->credit_val??0}}">
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
            <div class="form-group" id="status">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
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
