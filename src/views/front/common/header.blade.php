@include('laravel-common::front.common.header_common')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/common.css') }}">
<style>
    .header{background-color:rgb(255,255,255);box-shadow:0 1px 4px rgb(24 38 16 / 10%);width:100%;z-index:1100;top:0px;left:0;right:0px}
    .header .container{align-items:center;height:70px}
    .header2{margin-right:auto}
    .header2 ul{display:flex}
    .header2 ul li{}
    .header3{display:flex}
    .header3 ul{display:flex}
    .header3 ul a{width:44px;height:44px;display:block;margin:0 5px}
    .header3 ul a li{border-radius:50%;background:#eee;height:100%;display:flex;justify-content:center;align-items:center}
    .header3 ul a li i{font-size:26px;color:#333}
    .header3 ul a li:hover{background:#e5e5e5}
    .header31 input{border:none;outline-style:none;background:transparent;width:100px;transition:all 0.5s}
    .header31{background:#eee;display:flex;align-items:center;border-radius:40px;margin:0 5px;padding:0 10px}
    .header31 i{margin-right:5px}
    .header31 input:focus{width:150px}
    .header3 .dropdown-menu{padding:10px 0px;border:none;margin:14px 0px 12px;width:200px;background-color:rgb(255,255,255);box-shadow:rgb(0 0 0 / 16%) 0px 2px 10px 0px;border-radius:4px}
    .header3 .dropdown-menu a{width:100%;box-sizing:border-box;line-height:35px;font-weight:600;height:35px;padding:0 15px;margin:0}
    .header3 .dropdown-menu a:hover{background-color:rgba(0,0,0,0.04)}
</style>

    <div class="header d-none">
        <div class="container d-flex justify-content-between">
            <div class="header1">world</div>
            <div class="header2">
                <ul>
                    <a href=""><li>Series</li></a>
                    <a href=""><li>Bookmarks</li></a>
                    <a href=""><li>Resources</li></a>
                </ul>
            </div>
            <div class="header3">
                <div class="header31">
                    <i class="user-iconfont icon-sousuo"></i>
                    <input type="search" placeholder="Search">
                </div>
                <ul>
                    <a href="/account/group"><li><i class="user-iconfont icon-zuanshi"></i></li></a>
                    <a href=""><li><i class="user-iconfont icon-tongzhi"></i></li></a>
                    @if($user)
                        <div class="dropdown">
                            <a href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><li><i class="user-iconfont icon-touxiang"></i></li></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item d-flex" href="javascript:void(0)">
                                    <div class=""><i class="user-iconfont icon-touxiang"></i></div>
                                    <div>{{$user['nickname']}}</div>
                                </a>
                                <a class="dropdown-item" href="/account/index">Profile</a>
                                <a class="dropdown-item" href="/account/bookmarks">Bookmarks</a>
                                <a class="dropdown-item" href="/account/group">{{$user->group->name}}</a>
                                <a class="dropdown-item" href="/account/credit">Point</a>
                                <a class="dropdown-item ajax_post" href="/account/logout">Log out</a>
                            </div>
                        </div>
                    @else
                        <a href="/account/login"><li><i class="user-iconfont icon-touxiang"></i></li></a>
                    @endif
                </ul>
            </div>
        </div>
    </div>

