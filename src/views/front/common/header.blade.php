@include('laravel-common::front.common.header_common')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/common.css') }}">
<style>
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
    .header31 input{border:none;outline-style:none;background:transparent;width:100px;transition:all 0.5s;line-height: 44px;}
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

<div class="header">
    <div class="container d-flex justify-content-between">
        <div class="header1">
            <div class="header11">
                <img src="" alt="">
            </div>
            <div class="header13 d-xl-none" onclick="menu_ext()">
                <i class="common-iconfont icon-caidan1"></i>
            </div>
        </div>

        <div class="header2 d-none d-xl-block">
            <ul class="menu d-flex">
                @if(isset($link[1]['child']))
                    @foreach($link[1]['child'] as $val)
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
        <div class="header3">
            <div class="d-none d-xl-block">
                <form action="/novel/index" method="get">
                    <div class="header31">
                        <i class="common-iconfont icon-sousuo"></i>
                        <input type="search" name="title" placeholder="Search">
                    </div>
                </form>
            </div>
            <ul>
                <div class="dropdown">
                    <a href="javascript:void(0)" id="zuanshi" data-toggle="dropdown" aria-expanded="false"><li><i class="common-iconfont icon-zuanshi"></i></li></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="zuanshi">
                        <a class="dropdown-item" href="javascript:void(0)" >
                            <div onclick="checkin(this)">checkin</div>
                            <div>checkin</div>
                        </a>
                        <a class="dropdown-item" href="/account/credit">Point</a>
                        <a class="dropdown-item" href="/account/group">VIP</a>
                    </div>
                </div>
                <a href="/account/novel/bookmarks"><li><i class="common-iconfont icon-24gf-bookmarks"></i></li></a>
                @if($user)
                    <div class="dropdown">
                        <a href="javascript:void(0)" id="touxiang" data-toggle="dropdown" aria-expanded="false"><li><i class="common-iconfont icon-touxiang"></i></li></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="touxiang">
                            <a class="dropdown-item d-flex" href="javascript:void(0)">
                                <div class=""><i class="common-iconfont icon-touxiang"></i></div>
                                <div>{{$user['nickname']}}</div>
                            </a>
                            <a class="dropdown-item" href="/account/index">Profile</a>
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
<div class="m_header_ext d-xl-none">
    <div class="m_header_ext1">
        <form action="/novel/index" method="get">
        <div class="m_header_ext11">
            <i class="common-iconfont icon-sousuo"></i>
            <input type="search" name="title" placeholder="Search">
        </div>
        </form>
    </div>
    <div class="m_header_ext2">
        <ul>
            @if(isset($link[1]['child']))
                @foreach($link[1]['child'] as $val)
                    <a href="{{$val['url']}}"><li>{{$val['name']}}</li></a>
                @endforeach
            @endif

            @if(isset($link[1]['child']))
                @foreach($link[1]['child'] as $val)
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
</div>
<style>
    .m_header_ext{position: fixed;top: 70px;left: 0;width: 100%;height: 0;z-index:1100;transition: all 0.5s;background: #fff;overflow: hidden;}
    .m_header_ext.active{height: calc(100% - 70px);padding: 0 15px;}
    .m_header_ext11 input{border:none;outline-style:none;background:transparent;width:100%;transition:all 0.5s;height: 44px;}
    .m_header_ext11{background:#eee;display:flex;align-items:center;border-radius:40px;margin:0 5px;padding:0 10px;height: 100%;}
    .m_header_ext11 i{margin-right:5px}
    .m_header_ext2 li{height: 38px;line-height: 38px;font-size: 17px;font-weight: 700;}
    .m_header_ext1{padding: 10px 0;}
</style>
<div class="headerX"></div>
<script>
function menu_ext() {
    let _this = $('.m_header_ext');
    if(_this.hasClass('active')){
        _this.removeClass('active')
    }else{
        _this.addClass('active')
    }
}
function checkin(_this) {
    $.ajax({
        url:'/account/checkin',
        type:'post',
        data:{'_token':'{{csrf_token()}}'},
        success:function (res) {
            console.log(res)
            $(_this).html('xxx')
        }
    })
}
</script>
