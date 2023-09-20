@include('laravel-common-front::common.header_common')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ URL::asset('static/common/css/common.css') }}">
<link rel="stylesheet" href="{{ URL::asset('static/common/css/font.css') }}">
<style>
:root{
    --btn_bg: #f39797;
    --btn_color:#fff;
    --btn_bg_hover: #e57a6f;
    --btn_color_hover:#fff;
}
.m_menu1111{width: 30%;}
.header11{margin-right: 20px;}
.text-brand {
    --tw-gradient-from: #f8abad !important;
    --tw-gradient-to: #de8080 !important;
    --tw-gradient-stops: var(--tw-gradient-from),var(--tw-gradient-to,rgba(28,157,254,0));
    background-image: linear-gradient(to right,var(--tw-gradient-stops));
}
header a:hover{color:#de8080 !important;}
.btn-apply-code{background: #e3a086 !important;}
.checkout_ul li.active{border: 1px solid #de8080 !important;font-weight: 600}
.info_option label.active{border: 1px solid #de8080 !important;}
.info_option label:hover{border: 1px solid #fcc5c6 !important;}
.cart_num, .wishlist_num{background: #de8080;}
.wishlist_one i{color: #de8080;}
.sidebar-menu ul li a.active{color:var(--btn_bg) !important;}
</style>
<header>
    <div class="header1">
        <div class="container header10">
            <div class="d-flex header101">
                <div class="header11">
                    <a href="/"><img src="{{ URL::asset('logo.png') }}" alt="logo"></a>
                    <i class="common-iconfont icon-caidan logo_menu" ></i>
                </div>
                <div class="header11_m">
                    <i class="common-iconfont icon-caidan logo_menu" onclick="$('.m_menu').toggle()"></i>
                    <i class="common-iconfont icon-sousuo" onclick="$('.search_m').toggle()"></i>
                </div>
                <div class="header12_m">
                    <a href="/"><img src="{{ URL::asset('logo.png') }}" alt="logo"></a>
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
                    <a class="wishlist" href="/account_ext/wishlist?redirect={{urlencode(request()->url())}}">
                        <i class="common-iconfont icon-aixin" ></i><span class="wishlist_num" id="wishlist_num">{{$wishlist_num}}</span></a>
                    <a href="/cart"><i class="common-iconfont icon-31gouwuche"></i><span class="cart_num" id="cart_num">{{$cart_num}}</span></a>
                    @if($user)
                        <a href="/account/index?redirect={{urlencode(request()->url())}}"><i class="uni app-login"></i></a>
                    @else
                        <a href="/account/index?redirect={{urlencode(request()->url())}}"><i class="uni app-touxiang"></i></a>
                    @endif
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
                        <a href="/"><img src="{{ URL::asset('logo.png') }}" alt="logo"></a>
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
</style>

<main>
