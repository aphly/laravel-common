@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/account.css') }}">
<section class="">
    <div class="container">
        <form class="account_form" id="register"  method="post" action="/account/register">
            @csrf
            <div class="accountContent">
                <div class=" text-center ">
                    <h1 class="title ">
                        <div class="d-inline-block position-relative">
                            Create Account
                        </div>
                    </h1>
                    <div class="descrip">
                        Please provide the following
                        <br>information to create an account
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="id" class="form-control" required autocomplete="off" placeholder="you@example.com">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control password" required autocomplete="off" placeholder="Enter 6 characters or more">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required autocomplete="off" placeholder="Enter 6 characters or more">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="">
                        <label class="d-flex">
                            <input type="checkbox" name="agree" value="1" onclick="return false;" checked="checked">
                            <span class="agree">I have read and agree to <a class="underline" target="_blank" href="">Privacy Policy</a> .</span>
                        </label>
                    </div>
                    <div id="msg_check" class="d-none"></div>
                    <button class="btn createBtn text-brand">Register</button>
                </div>
            </div>
        </form>
    </div>
</section>
<style>

</style>
<script>
    let form_id = '#register'
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
