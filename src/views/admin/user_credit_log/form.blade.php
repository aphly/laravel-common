
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/common_admin/user_credit_log/save?id={{$res['info']->id}}" @else action="/common_admin/user_credit_log/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">id</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->id??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">uuid</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->uuid??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">pre</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->pre??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">key</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->key??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">val</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->val??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">type</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->type??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">reason</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->reason??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">created_at</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->created_at??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">updated_at</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->updated_at??0}}">
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
