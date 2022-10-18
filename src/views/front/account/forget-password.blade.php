@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">

<section class="" >
    <div class="container">
        <form method="post" action="/account/forget-password/{{$res['token']}}" id="forget-password-set" class="account_form">
            @csrf
            <div class="accountContent">
                <h3 class="" style="margin-bottom: 20px;">
                    Reset password
                </h3>

                <div class="form-group">
                    <label for="">Email</label>
                    <div>{{$res['userAuth']->id}}</div>
                </div>

                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="new password" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>

                <button class="btn btn-primary text-brand" type="submit">Reset Password</button>
            </div>

        </form>
    </div>

</section>
<script>
let form_id = '#forget-password-set'
$(function (){
    $(form_id).submit(function (){
        const form = $(this)
        if(form[0].checkValidity()===false){
        }else{
            let url = form.attr("action");
            let type = form.attr("method");
            if(url && type){
                $(form_id+' input.form-control').removeClass('is-valid').removeClass('is-invalid');
                let btn_html = $(form_id+' button[type="submit"]').html();
                $.ajax({
                    type,url,
                    data: form.serialize(),
                    dataType: "json",
                    beforeSend:function () {
                        $(form_id+' button[type="submit"]').attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
                    },
                    success: function(res){
                        $(form_id+' input.form-control').addClass('is-valid');
                        console.log(res)
                        if(!res.code) {
                            location.href = res.data.redirect
                        }else if(res.code===11000){
                            for(let item in res.data){
                                let str = ''
                                res.data[item].forEach((elem, index)=>{
                                    str = str+elem+'<br>'
                                })
                                let obj = $(form_id+' input[name="'+item+'"]');
                                obj.removeClass('is-valid').addClass('is-invalid');
                                obj.next('.invalid-feedback').html(str);
                            }
                        }else{
                            alert_msg(res);
                        }
                    },
                    complete:function(XMLHttpRequest,textStatus){
                        $(form_id+' button[type="submit"]').removeAttr('disabled').html(btn_html);
                    }
                })
            }else{
                console.log('no action')
            }
        }
        return false;
    })
});
</script>
@include('laravel-common::front.common.footer')
