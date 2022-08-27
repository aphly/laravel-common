<div class="top-bar">
    <h5 class="nav-title">积分</h5>
</div>
<div class="imain">
    <form method="post" action="/common_admin/user/{{$res['info']->uuid}}/credit" class="save_form">
        @csrf
        <div>
            <div class="userinfo">
                uuid：{{$res['info']->uuid}}
            </div>
            <div class="userinfo">
                用户名：{{$res['info']['nickname']}}
            </div>
            <div class="form-group">
                <label for="">point</label>
                <input type="number" name="point"  class="form-control " value="{{$res['info']->point??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">silver</label>
                <input type="number" name="silver"  class="form-control " value="{{$res['info']->silver??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">gold</label>
                <input type="number" name="gold"  class="form-control " value="{{$res['info']->gold??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

