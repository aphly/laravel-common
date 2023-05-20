@include('laravel-common-front::common.header_common')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ URL::asset('static/common/css/common.css') }}">
<link rel="stylesheet" href="{{ URL::asset('static/common/css/font.css') }}">

<style>
    body{font-family: 'Montserrat';background: #f6f6f6;}
    html.no_scroll, html.no_scroll body {overflow: hidden!important;height: 100%!important;}
    .header1{height: 80px;padding: 0 10px;position: fixed;left: 0;top: 0;width: 100%;background: #fff;z-index: 2000;}
    .header13 i{font-size: 27px;font-weight: 400;margin:0 10px;}
    .header13 a{position: relative;}
    .cart_num{position: absolute;right:0;top: 0;font-size: 12px;width: 16px;height: 16px;color: #fff;background: #333;text-align: center;border-radius: 50%;}
    main{padding: 80px 0;min-height: 800px;}
    .header10{height: 100%;}
    .header101{height: 100%;}
    .logo_menu{display: none}
    .header12{margin-right: auto;}
    .header12 .menu li .pc_menu_lv1_a{font-weight: 600;font-size: 16px;padding: 40px 20px 0;display: block;height: 100%;}
    .header12 .menu li{position: relative;}
    .header12 .menu{height: 100%;}
    .pc_menu_lv2{display: none;position: fixed;left: 0;background: #fff;width: 100%;box-shadow:0 2px 12px 2px #eee;}
    .pc_menu_lv21{padding:40px 15px 80px;display: flex;}
    .pc_menu_lv2_a{color:#333;font-weight: 600;font-size: 15px;display: block;margin-bottom: 10px;}
    .pc_menu_lv3 a{display: block;line-height: 30px;}
    .pc_menu_lv211{padding-right: 40px;min-width: 160px;}
    .search_pc{}
    .search_pc1{position: relative;display: flex;align-items: center;margin-right: 20px; padding-top: 30px;}
    .search_pc11{border-radius: 4px;margin-bottom: 0; border: 1px solid #ddd;line-height: 34px;height: 36px; width: 100%; padding: 0 8px;}
    .search_pc12{position: absolute;right: 10px;border: none;border-radius: 4px;}
    .header11 img{  height: 60px;margin-top: 10px;}
    .header11_m,.header12_m{display: none;}
    .header13{padding-top: 30px;}
    .shop_main{margin-top: 10px;}
    @media (max-width: 1199.98px) {
        main{padding: 60px 0 40px;}
        .header1{height: 55px;padding: 0;}
        .header1 i{font-size: 20px;}
        .header13 i{margin:0 5px;}
        .logo_menu{display: block;padding: 0 10px;}
        .header12,.search_pc{display: none;}
        .header11{display: none;}
        .header101{height: 100%;align-items: center;margin-top: 0;justify-content: space-between;}
        .header12_m img{height: 45px;}
        .header13 a{padding: 0 5px;}
        .header11_m,.header12_m{display: block;}
        .header13 .wishlist{display: none;}
        .header11_m,.header13{width: 30%;}
        .header11_m{display: flex;}
        .header11_m i{padding: 0 10px;}
        .header13{flex-direction: row-reverse;}
    }
</style>
<header>
    <div class="header1">
        <div class="container header10">
            <div class="d-flex header101">
                <div class="header11">
                    <a href="/"><img src="{{ URL::asset('static/common/img/logo.png') }}" alt="logo"></a>
                    <i class="common-iconfont icon-caidan logo_menu" ></i>
                </div>
                <div class="header11_m">
                    <i class="common-iconfont icon-caidan logo_menu" onclick="$('.m_menu').toggle()"></i>
                    <i class="common-iconfont icon-sousuo" onclick="$('.search_m').toggle()"></i>
                </div>
                <div class="header12_m">
                    <a href="/"><img src="{{ URL::asset('static/common/img/logo.png') }}" alt="logo"></a>
                </div>
                <div class="header12">
                    <ul class="menu d-flex">
                        @if(isset($links['child']))
                            @foreach($links['child'] as $val)
                                <li>
                                    @if(isset($val['child']))
                                        @php $val['child_url'] = array_column($val['child'],'url'); @endphp
                                        <a href="{{$val['url']??'javascript:void(0)'}}" class="pc_menu_lv1_a wenzi {{(request()->is($val['url']) || in_array($val['url'],$val['child_url']))?'active':''}}">{{$val['name']}}</a>
                                        <div class="pc_menu_lv2" >
                                            <div class="container pc_menu_lv21">
                                                @foreach($val['child'] as $v)
                                                    <div class="pc_menu_lv211">
                                                        @if(isset($v['child']))
                                                            <a href="{{$v['url']??'javascript:void(0)'}}" class="pc_menu_lv2_a">{{$v['name']}}</a>
                                                            <div class="pc_menu_lv3">
                                                                @foreach($v['child'] as $v1)
                                                                    <a class="pc_menu_lv3_a wenzi" href="{{$v1['url']}}">{{$v1['name']}}</a>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <a class="pc_menu_lv2_a wenzi" href="{{$v['url']}}">{{$v['name']}}</a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    @else
                                        <a href="{{$val['url']}}" class="pc_menu_lv1_a wenzi {{request()->is($val['url'])?'active':''}}">{{$val['name']}}</a>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="search_pc">
                    <div class="search_pc1">
                        <input type="text" autocomplete="off" name="name" value="" placeholder="Search" class="search_pc11" maxlength="128">
                        <button type="submit" class="search_pc12 search_btn"><i class="common-iconfont icon-sousuo"></i></button>
                    </div>
                </div>
                <div class="d-flex header13">
                    <a class="wishlist" href="/account_ext/wishlist?redirect={{urlencode(request()->url())}}"><i class="common-iconfont icon-aixin"></i><span class="wishlist_num">{{$wishlist_num}}</span></a>
                    <a href="/cart"><i class="common-iconfont icon-31gouwuche"></i><span class="cart_num">{{$cart_num}}</span></a>
                    <a href="/account/index?redirect={{urlencode(request()->url())}}"><i class="uni app-touxiang"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="m_search_btn" onclick="$('.search_m').toggle()" style="display: none;">
        <i class="common-iconfont icon-sousuo"></i>
    </div>
    <div class="search_m" style="display: none">
        <div class="search_m1 container">
            <div class="d-flex justify-content-between search_m11">
                <div class="search_m111">Search</div>
                <div class="search_m112" onclick="$('.search_m').toggle()"><i class="uni app-guanbi"></i></div>
            </div>
            <div class="search_m12">
                <input type="text" autocomplete="off" name="name" value="" placeholder="Search" class="" maxlength="128">
                <button type="submit" class="search_btn"><i class="common-iconfont icon-sousuo"></i></button>
            </div>
            <div class="search_m13">
                <span class="label">Popular Searches:</span>
            </div>
        </div>
    </div>

    <div class="m_menu" style="display: none;">
        <div class="m_menu1 d-flex">
            <div class="m_menu11">
                <div class="d-flex justify-content-between align-items-center m_menu111">
                    <div class="m_menu1111">

                    </div>
                    <div class="m_menu1112" onclick="$('.m_menu').toggle()">
                        <i class="uni app-guanbi"></i>
                    </div>
                </div>
                <ul class="m_menu112">
                    @if(isset($links['child']))
                        @foreach($links['child'] as $val)
                            <li>
                                @if(isset($val['child']))
                                    @php $val['child_url'] = array_column($val['child'],'url'); @endphp
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{$val['url']??'javascript:void(0)'}}" class="menu_lv1_a wenzi {{(request()->is($val['url']) || in_array($val['url'],$val['child_url']))?'active':''}}">{{$val['name']}}</a>
                                        <i class="uni app-jia1" data-toggle="collapse" data-target="#multiCollapse{{$val['id']}}"
                                           role="button" aria-expanded="false" aria-controls="multiCollapse{{$val['id']}}"></i>
                                    </div>
                                    <div class="collapse multi-collapse menu_lv2" id="multiCollapse{{$val['id']}}">
                                        @foreach($val['child'] as $v)
                                            @if(isset($v['child']))
                                            <div>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{$v['url']??'javascript:void(0)'}}" class="menu_lv2_a">{{$v['name']}}</a>
                                                    <i class="uni app-jia1" data-toggle="collapse" data-target="#multiCollapse{{$v['id']}}"
                                                       role="button" aria-expanded="false" aria-controls="multiCollapse{{$v['id']}}"></i>
                                                </div>
                                                <div class="collapse multi-collapse menu_lv3" id="multiCollapse{{$v['id']}}">
                                                    @foreach($v['child'] as $v1)
                                                        <a class="menu_lv3_a wenzi" href="{{$v1['url']}}">{{$v1['name']}}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @else
                                                <a class="menu_lv2_a wenzi" href="{{$v['url']}}">{{$v['name']}}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                    <a href="{{$val['url']}}" class="menu_lv1_a wenzi {{request()->is($val['url'])?'active':''}}">{{$val['name']}}</a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
                <div class="m_menu113">
                @if($currency[0] && $currency[1] && $currency[2] && count($currency[0])>1 )
                    <div class="currency_box">
                        <div class="currency_curr">
                            <div class="baCountry baCountry-{{$currency[2]['code']}}"></div>
                            <span class="ba-chosen ">{{$currency[2]['code']}}</span>
                        </div>
                        <ul class="baDropdown">
                            @foreach($currency[0] as $val)
                                <li class="currMovers @if($currency[2]['code']==$val['code']) active @endif" data-id="{{$val['id']}}">
                                    <div class="baCountry baCountry-{{$val['code']}}"></div>
                                    <span class="curChoice wenzi">{{$val['name']}} ({{$val['code']}})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                </div>
            </div>

            <div class="menu_r" onclick="$('.m_menu').toggle()">
                <i class="uni app-guanbi"></i>
            </div>
        </div>
    </div>

</header>

<script>
$(function () {
    $('header').on('click','.search_btn',function () {
        let name = $(this).siblings('input').val()
        if(name){
            location.href='/product?name='+name
        }
    })
    $('.m_menu11 .m_menu112').on('click','i',function () {
        let status = $(this).attr('aria-expanded')
        if(status=='true'){
            $(this).removeClass('app-jian1').addClass('app-jia1')
        }else{
            $(this).removeClass('app-jia1').addClass('app-jian1')
        }
    })

    $('.pc_menu_lv1_a').hover(function () {
        $(this).siblings('.pc_menu_lv2').slideDown();
    },function () {
        $('.pc_menu_lv2').hide();
    })
    $('.pc_menu_lv2').hover(function () {
        $(this).show();
    },function () {
        $(this).hide();
    })

})
</script>

<style>
.m_menu112{height: calc(100% - 150px);overflow-y: auto;}
.m_menu .currency_box{display: block;width: 100%;position: relative;left: 0;bottom: 0;}
.m_menu .currency_box .baDropdown{width: 100%;}
.search_m{position: fixed;top: 0;height: 100%;left: 0;width: 100%;background: #fff;z-index: 2000;}
.search_m1{padding-top:32px;}
.search_m11{font-weight: 600;height: 36px;margin-bottom: 10px;align-items: center;}
.search_m12{height: 46px;border-bottom: 2px solid #999;}
.search_m112{padding: 0 10px;line-height: 36px;}
.search_m12 input{border:none;height: 100%;width: calc(100% - 50px);}
.search_m12 button{width: 40px;height: 40px;border: none;margin-left: 5px;background: transparent}
.search_m12 button i{font-size: 20px;}
.search_m13{margin-top: 10px;line-height: 28px}
.search_m13 .label{color:#777;}
.m_search_btn{color:#000;font-weight:600;font-size:12px;display:block;position:fixed;bottom:calc(50% + 90px);right:0;background:#fafafa;padding:11px;z-index:100;border-bottom-left-radius:8px;border-top-left-radius:8px}

.m_menu1{position: fixed;top: 0;height: 100%;left: 0;width: 100%;z-index: 2001;}
.m_menu11{width: 100%; background: #FFF;padding: 20px;position: relative;}
.menu_r{width: 50px; background: rgba(0,0,0,0.5);justify-content: center; align-items: center;color: #fff;display: none;}
.m_menu11 li{line-height: 54px;}
.m_menu11 li .menu_lv1_a{font-weight: 500;font-size: 18px; color: #000;padding: 0;}
.m_menu111{margin-bottom: 20px; line-height: 34px;}
.m_menu1112{width: 60px;text-align: right;}
.m_menu1112 i{font-size: 20px;}
.menu_lv1_a,.menu_lv2_a,.menu_lv3_a{display: block;width:calc(100% - 60px);}
.menu_lv2_a{font-size: 16px;color:#787A7C;}
.menu_lv3{padding-left: 10px;border-left: 1px solid #f1f1f1;}
.m_menu11 ul i{width: 60px;text-align: right;}
.menu_lv2{padding-left: 10px;}
.m_menu113{margin-top: 20px;}
@media (max-width: 1199.98px) {
    .currency_box{display: none}
}
</style>
@if($currency[0] && $currency[1] && $currency[2] && count($currency[0])>1 )
    <div class="currency_box">
        <div class="currency_curr">
            <div class="baCountry baCountry-{{$currency[2]['code']}}"></div>
            <span class="ba-chosen ">{{$currency[2]['code']}}</span>
        </div>
        <ul class="baDropdown">
            @foreach($currency[0] as $val)
                <li class="currMovers @if($currency[2]['code']==$val['code']) active @endif" data-id="{{$val['id']}}">
                    <div class="baCountry baCountry-{{$val['code']}}"></div>
                    <span class="curChoice wenzi">{{$val['name']}} ({{$val['code']}})</span>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        let currency_data = @json($currency[0]);
        $(function () {
            $('.currency_box .currency_curr').click(function () {
                $('.baDropdown').toggle();
            })
            $('.currency_box .baDropdown').on('click','li',function () {
                let id  =$(this).data('id')
                $.ajax({
                    url:'/currency/'+id,
                    dataType: "json",
                    success: function(res){
                        location.reload()
                    }
                })
            })
        })
    </script>
@endif
<main>
