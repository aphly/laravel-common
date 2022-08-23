
<div class="top-bar">
    <h5 class="nav-title">user credit order</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/common_admin/user_credit_order/save?id={{$res['info']->id}}" @else action="/common_admin/user_credit_order/save" @endif class="save_form">
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
                <label for="">credit_price_id</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->credit_price_id??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">total</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->total??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">payment_id</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->payment_id??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">status</label><br>
                @if($dict['payment_status'])
                    @if($res['info']->status==2)
                        <span class="badge badge-success ">{{$dict['payment_status'][$res['info']->status]}}</span>
                    @else
                        <span class="badge badge-secondary ">{{$dict['payment_status'][$res['info']->status]}}</span>
                    @endif
                @endif
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
