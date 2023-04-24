
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" action="/common_admin/user/{{$res['info']['uuid']}}/avatar" class="save_form_file"  enctype="multipart/form-data">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">头像图片</label>
                <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" name="avatar" class="form-control-file " >
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">上传</button>
        </div>
    </form>
</div>
