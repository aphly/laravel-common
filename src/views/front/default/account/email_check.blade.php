@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">

<div class=" container">
    <div class="account_msg">
        <p>{{$res['msg']}}</p>
    </div>
</div>


@include('laravel-common-front::common.footer')
