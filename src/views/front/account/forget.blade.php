@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<section class="" >
    <div class="forget container">
        <form method="post" action="/account/forget?return_url={{urlencode(request()->query('return_url',''))}}" id="forget" class="account_form">
            @csrf
            <div class="accountContent">
                <h3 class="" style="margin-bottom: 20px;">
                    Forgot your password?
                </h3>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" name="id" class="form-control" placeholder="Email" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="alert alert-warning d-none" id="msg"></div>

                <button class="btn btn-primary text-brand" type="submit">Reset Password</button>

            </div>
        </form>
    </div>

</section>
<script>
let form_id = '#forget'
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
                        if(!res.code) {
                            location.href = res.data.redirect
                        }else if(res.code===11000){
                            form_err_11000(res,form_id);
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
