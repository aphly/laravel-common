@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">

<div class="container">
    <div class="account_msg" style="">
        @if($user)
            @if($user->verified)
                <p >Your email has been verified. </p>
                <a href="/">Home</a>
            @else
                <p >Help us secure your account by verifying your email address. </p>
                <a href="/account/email-verify/send" class="ajax_post">Send email again</a>
            @endif
        @endif
    </div>
</div>

@include('laravel-common-front::common.footer')
