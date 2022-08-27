@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/account.css') }}">
<section class="" >
    <div class="forget container">
        <form method="post" action="/account/forget?return_url={{urlencode(request()->query('return_url',''))}}" id="forget" class="account_form">
            @csrf
            <div class="accountContent">
                <h3 class="">
                    Forgot your password?<br>
                    Enter your email.
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
    $(form_id).submit(function (event){
        event.preventDefault()
        event.stopPropagation()
        const form = $(this)
        if(form[0].checkValidity()===false){
        }else{
            let url = form.attr("action");
            let type = form.attr("method");
            if(url && type){
                $(form_id+' input.form-control').removeClass('is-valid').removeClass('is-invalid');
                $.ajax({
                    type,url,
                    data: form.serialize(),
                    dataType: "json",
                    success: function(res){
                        $(form_id+' input.form-control').addClass('is-valid');
                        if(!res.code) {
                            location.href = res.data.redirect
                        }else if(res.code===11000){
                            for(var item in res.data){
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
                        //console.log(XMLHttpRequest,textStatus)
                    }
                })
            }else{
                console.log('no action')
            }
        }

    })
});
</script>
@include('laravel-common::front.common.footer')
