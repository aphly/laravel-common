@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<style>
.res1{text-align: center;}
.res1 i{font-size: 70px;font-weight: 600;color: #02bb4c;}
.res2{font-size:20px;text-align: center;margin-bottom: 20px;}
.res3{text-align: center;}
.res3 a{padding: 8px 20px;border-radius: 4px;background: var(--a-hover);color: #fff;font-size: 16px;font-weight: 600;display: inline-block;}
</style>
<section class="">
    <div class="container d-flex justify-content-center">
        <div class="success">
            <div class="res1">
                <i class="common-iconfont icon-chenggong1"></i>
            </div>
            <div class="res2">
                Your order has been processed successfully!
            </div>
            @if(!empty($res['payment']))
            <div class="res3">
                <a href="{{$res['payment']->cancel_url}}">continue</a>
            </div>
            @endif
        </div>
    </div>
</section>

<script>

</script>
@include('laravel-common::front.common.footer')
