
<div class="top-bar">
    <h5 class="nav-title">修改头像 {{$res['info']['nickname']}}</h5>
</div>
<div class="imain">
    <form method="post" action="/common_admin/user/{{$res['info']['uuid']}}/avatar" class="upload_form" onsubmit="uploadAvatar(event,this)" enctype="multipart/form-data">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">头像图片</label>
                <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" id="avatar" name="avatar" class="form-control-file " >
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">上传</button>
        </div>
    </form>
</div>

<script>
    function uploadAvatar(e,_this){
        e.preventDefault()
        e.stopPropagation()
        const form = $(_this)
        let formData = new FormData();
        formData.append('avatar', $("#avatar")[0].files[0]);
        formData.append('_token', '{{csrf_token()}}');
        let url = form.attr("action");
        let type = form.attr("method");
        if(url && type){
            $('.upload_form input.form-control').removeClass('is-valid').removeClass('is-invalid');
            $.ajax({
                type,url,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    $('.upload_form input.form-control').addClass('is-valid');
                    if(!res.code) {
                        $("#iload").load(res.data.redirect);
                        alert_msg(res)
                    }else{
                        alert_msg(res)
                    }
                },
                complete:function(XMLHttpRequest,textStatus){
                    //console.log(XMLHttpRequest,textStatus)
                }
            })
        }else{
            console.log('no action'+url+type)
        }
    }
</script>
