@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<section class="">
    <div class="container">
        @if($user)
            @if($user->verified)
                <a href="/">ok</a>
            @else
                <a href="/account/mail-verify/send" class="ajax_post">send</a>
            @endif
        @endif
    </div>
</section>

@include('laravel-common::front.common.footer')
