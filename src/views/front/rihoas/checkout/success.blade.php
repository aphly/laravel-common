@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<style>
.checkout_res{margin: 10% 0;}
.res1{text-align: center;}
.res1 i{font-size: 70px;font-weight: 600;color: #02bb4c;}
.res2{font-size:20px;text-align: center;margin-bottom: 20px;}
.res3{text-align: center;}
.res3 a{padding: 8px 20px;border-radius: 4px;background: var(--a-hover);color: #fff;font-size: 16px;font-weight: 600;display: inline-block;}
.res4{margin-top: 20px;font-size: 12px;color: #999; text-align: center;}
.res4 .second{padding: 0 5px;}
</style>
<section class="">
    <div class="container d-flex justify-content-center">
        <div class="checkout_res">
            <div class="res1">
                <i class="common-iconfont icon-chenggong1"></i>
            </div>
            <div class="res2">
                Your order has been processed successfully!
            </div>
            @if(!empty($res['redirect']))
            <div class="res3">
                <a href="{{$res['redirect']}}">continue</a>
            </div>
            <div class="res4">
                Jump in<span class="second" >5</span>seconds
            </div>
            @endif
        </div>
    </div>
</section>

<script>
    let time = 4;
    let url = '{{$res['redirect']}}';
    let second = $('.second')
    let djs =  setInterval(function () {
        if(time>0){
            second.html(time)
            time--;
        }else{
            clearInterval(djs)
            if(url){
                location.href = url;
            }
        }
    },1000)
</script>
@include('laravel-common-front::common.footer')
