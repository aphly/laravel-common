@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/account.css') }}">

<section class="">
    <div class="container d-flex justify-content-center">
        <div class="">
            <div>
                <i class="common-iconfont icon-chenggong1"></i>
            </div>
            <div>
                Your order has been processed failed!
            </div>
            @if(!empty($res['payment']))
                <div>
                    <a href="{{$res['payment']->cancel_url}}">continue</a>
                </div>
            @endif
        </div>
    </div>
</section>

<script>

</script>
@include('laravel-common::front.common.footer')
