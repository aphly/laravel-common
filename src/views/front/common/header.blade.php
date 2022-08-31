@include('laravel-common::front.common.header_common')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/common.css') }}">
<style>
    :root{
        --a-hover:#007aff;
        --body-bg:#f1f1f1;
    }
    .shadow {box-shadow: 0 0 #0000,0 0 #0000,0 2px 8px 0 rgba(0, 0, 0, .16);}
    .text-brand{font-weight: 600;--tw-gradient-from:#1c9dfe;--tw-gradient-to:#023ff4;--tw-gradient-stops:var(--tw-gradient-from),var(--tw-gradient-to,rgb(28 157 254/0));background-image:linear-gradient(to right,var(--tw-gradient-stops));border:none;color:#fff;margin-top: 15px;}

    .header{background-color:rgb(255,255,255);box-shadow:0 1px 4px rgb(24 38 16 / 10%);width:100%;z-index:1100;top:0px;left:0;right:0px;position: fixed;}
    .header .container{align-items:center;height:70px}
    .headerX{height:70px;width: 100%;}
    .header2{margin-right:auto}
    .header2 ul{display:flex}
    .header2 ul li{}
    .header3{display:flex}
    .header3 ul{display:flex}
    .header3 ul a{width:44px;height:44px;display:block;margin:0 5px}
    .header3 ul a li{border-radius:50%;background:#eee;height:100%;display:flex;justify-content:center;align-items:center}
    .header3 ul a li i{font-size:26px;color:#000}
    .header3 ul a li:hover{background:#e5e5e5}
    .header31 input{border:none;outline-style:none;background:transparent;width:100px;transition:all 0.5s}
    .header31{background:#eee;display:flex;align-items:center;border-radius:40px;margin:0 5px;padding:0 10px;height: 100%;}
    .header31 i{margin-right:5px}
    .header31 input:focus{width:150px}
    .header3 .dropdown-menu{padding:10px 0px;border:none;margin:14px 0px 12px;width:200px;background-color:rgb(255,255,255);box-shadow:rgb(0 0 0 / 16%) 0px 2px 10px 0px;border-radius:4px}
    .header3 .dropdown-menu a{width:100%;box-sizing:border-box;line-height:35px;font-weight:600;height:35px;padding:0 15px;margin:0}
    .header3 .dropdown-menu a:hover{background-color:rgba(0,0,0,0.04)}
    .header2{font-weight: 600;font-size: 16px;margin-left: 24px;}
    .header2 ul{display: flex;}
    .header2 ul li{margin-right: 16px;}
    .header2 a{color: #000;}
    .header1{display: flex;}
    .header13{display: flex;justify-content: center;align-items: center;}
    .header13 i{font-size: 26px;color:#000;}
    .header11 img{height: 100%;}
    .header11{width: 100px;margin-right: 10px;}
    @media (max-width: 1199.98px) {
        .header{}
    }
</style>

<div class="header d-none">
    <div class="container d-flex justify-content-between">
        <div class="header1">
            <div class="header11">
                <img src="" alt="">
            </div>
            <div class="header13 d-xl-none">
                <i class="common-iconfont icon-caidan"></i>
            </div>
        </div>

        <div class="header2 d-none d-xl-block">
            <ul>
                @if(isset($link[1]['child']))
                    @foreach($link[1]['child'] as $val)
                        <a href="{{$val['url']}}"><li>{{$val['name']}}</li></a>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="header3">
            <div class="d-none d-xl-block">
                <div class="header31">
                    <i class="common-iconfont icon-sousuo"></i>
                    <input type="search" placeholder="Search">
                </div>
            </div>
            <ul>
                <a href="/account/group"><li><i class="common-iconfont icon-zuanshi"></i></li></a>
                <a href="/account/novel/bookmarks"><li><i class="common-iconfont icon-24gf-bookmarks"></i></li></a>
                @if($user)
                    <div class="dropdown">
                        <a href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><li><i class="common-iconfont icon-touxiang"></i></li></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item d-flex" href="javascript:void(0)">
                                <div class=""><i class="common-iconfont icon-touxiang"></i></div>
                                <div>{{$user['nickname']}}</div>
                            </a>
                            <a class="dropdown-item" href="/account/index">Profile</a>
                            <a class="dropdown-item" href="/account/credit">Point</a>
                            <a class="dropdown-item ajax_post" href="/account/logout">Log out</a>
                        </div>
                    </div>
                @else
                    <a href="/account/login"><li><i class="common-iconfont icon-touxiang"></i></li></a>
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="headerX"></div>

