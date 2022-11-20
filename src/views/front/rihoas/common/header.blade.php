@include('laravel-common-front::common.header_common')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ URL::asset('static/common/css/common.css') }}">
<link rel="stylesheet" href="{{ URL::asset('static/common/css/font.css') }}">

<style>
    body{font-family: 'Montserrat';}
    .header{height: 100px;padding: 0 10px;position: fixed;left: 0;top: 0;width: 100%;background: #fff;z-index: 1;}
    .header i{font-size: 30px;font-weight: 600}
    .header3{}
    .header3 a{position: relative;}
    .cart_num{position: absolute;right:0;top: 0;font-size: 12px;width: 16px;height: 16px;color: #fff;background: #333;
    text-align: center;border-radius: 50%;}
    .header3 i{margin:0 10px;}
    main{padding-top: 100px;}
    @media (max-width: 1199.98px) {
        .header{height: 50px;}
        .header i{font-size: 20px;}
        .header3 i{margin:0 5px;}
        main{padding-top: 50px;}
    }

</style>
<header>
    <div class="d-flex justify-content-between header align-items-center">
        <div class="header1">
            <i class="common-iconfont icon-caidan"></i>
        </div>
        <div class="header2">

        </div>
        <div class="d-flex header3">
            <a href="/wishlist"><i class="common-iconfont icon-aixin"></i></a>
            <a href="/cart"><i class="common-iconfont icon-31gouwuche"></i><span class="cart_num">{{$cart_num}}</span></a>
            <a href="/account/index"><i class="common-iconfont icon-dengluzhanghao"></i></a>
        </div>
    </div>
    <div>

    </div>
    <div>

    </div>
</header>
<script>

</script>

<style>


</style>
<main>
