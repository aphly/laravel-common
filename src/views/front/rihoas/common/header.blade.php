@include('laravel-common-front::common.header_common')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ URL::asset('static/common/css/common.css') }}">
<link rel="stylesheet" href="{{ URL::asset('static/common/css/font.css') }}">

<style>
    body{font-family: 'Montserrat';background: #f6f6f6;}

    .header1{height: 80px;padding: 0 10px;position: fixed;left: 0;top: 0;width: 100%;background: #fff;z-index: 2000;}
    .header1 i{font-size: 30px;font-weight: 600}
    .header13 a{position: relative;}
    .header13 i{margin:0 10px;}

    .cart_num{position: absolute;right:0;top: 0;font-size: 12px;width: 16px;height: 16px;color: #fff;background: #333;text-align: center;border-radius: 50%;}

    main{padding-top: 100px;min-height: 800px;}
    @media (max-width: 1199.98px) {
        .header1{height: 55px;}
        .header1 i{font-size: 20px;}
        .header13 i{margin:0 5px;}
        main{padding-top: 60px;padding-bottom: 40px;}
    }
</style>
<header>
    <div class="d-flex justify-content-between header1 align-items-center">
        <div class="header11">
            <i class="common-iconfont icon-caidan"></i>
        </div>
        <div class="header12">

        </div>
        <div class="d-flex header13">
            <a href="/account/wishlist?redirect={{urlencode(request()->url())}}"><i class="common-iconfont icon-aixin"></i><span class="wishlist_num">{{$wishlist_num}}</span></a>
            <a href="/cart"><i class="common-iconfont icon-31gouwuche"></i><span class="cart_num">{{$cart_num}}</span></a>
            <a href="/account/index?redirect={{urlencode(request()->url())}}"><i class="common-iconfont icon-dengluzhanghao"></i></a>
        </div>
    </div>

    <div class="">
        <ul class="menu d-flex">
            @if(isset($links[1]['child']))
                @foreach($links[1]['child'] as $val)
                    <li>
                        @if(isset($val['child']))
                            @php $val['child_url'] = array_column($val['child'],'url'); @endphp
                            <a class="nav-link {{(request()->is($val['url']) || in_array($val['url'],$val['child_url']))?'active':''}}"
                               id="navbarDropdown{{$val['id']}}" role="button" data-toggle="dropdown" aria-expanded="false">{{$val['name']}}</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{$val['id']}}">
                                @foreach($val['child'] as $v)
                                    <a class="dropdown-item " href="{{$v['url']}}">{{$v['name']}}</a>
                                @endforeach
                            </div>
                        @else
                            <a href="{{$val['url']}}" class="nav-link {{request()->is($val['url'])?'active':''}}">{{$val['name']}}</a>
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</header>

<script>

</script>

<style>

</style>
<main>
