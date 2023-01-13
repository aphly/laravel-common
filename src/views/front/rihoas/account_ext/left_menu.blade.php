
<div class="sidebar-menu">
    <div class="sidebar-menu-list">
        <div class="sidebar-menu-title">My Account Information</div>
        <ul class="sidebar-menu-content">
            <li><a href="/account/index" @if('account/index'==request()->path()) class="active" @endif>Dashboard</a></li>
            <li><a href="/account_ext/wishlist" @if('account_ext/wishlist'==request()->path()) class="active" @endif>My Wishlist</a></li>
            <li><a href="/account_ext/address" @if('account_ext/address'==request()->path() || 'account_ext/address/save'==request()->path()) class="active" @endif>My Address Book</a></li>
            <li><a href="/account_ext/subscribe" @if('account_ext/subscribe'==request()->path()) class="active" @endif>My Subscribe</a></li>
        </ul>

        <div class="sidebar-menu-title">Order Details</div>
        <ul class="sidebar-menu-content">
            <li><a href="/account_ext/order" @if('account_ext/order'==request()->path()) class="active" @endif>My Orders</a></li>
            <li><a href="/account_ext/review" @if('account_ext/review'==request()->path() || 'account_ext/review/detail'==request()->path()) class="active" @endif>My Reviews</a></li>
        </ul>
        <div class="sidebar-menu-title">Customer Service</div>
        <ul class="sidebar-menu-content">
            <li><a href="/account_ext/service" @if('account_ext/service'==request()->path() || 'account_ext/service/form'==request()->path()) class="active" @endif>My Service</a></li>
            <li><a href="/account/logout" @if('account/logout'==request()->path()) class="active" @endif>Logout</a></li>
        </ul>
        <div class="sidebar-menu-content" style="">
            <span>Need help? We're here to help you:</span>
            <div class="phone">
                <b>{{ config('admin.email') }}</b> <br>
                <span>9:00 AM to 6:00 PM Mon to Fri. (EST)</span>
            </div>
        </div>
    </div>
</div>
<style>
    .sidebar-menu{width:280px;overflow:hidden;background: #fff;border-radius: 4px;padding: 20px}
    .sidebar-menu .sidebar-menu-title{padding-top:15px;padding-bottom:7px;margin:0 auto 20px;font-size:18px;font-weight:500}
    .sidebar-menu ul li{list-style:inside;color:#d8d8d8;padding-bottom:5px}
    .sidebar-menu ul li a{font-size:15px;color:#333}
    .sidebar-menu ul li a.active{color: #0da9c4;}

    .account-main-section{width: calc(100% - 300px);margin-left: 20px;background: #fff;border-radius: 4px;padding: 20px}
    .account_info{margin-top: 20px;display: flex;justify-content: space-between;}
    .top-desc{margin-bottom: 10px;}
    .top-desc a{color:#06b4d1;font-size: 16px;}
    .list_index{}
    .list_index li{margin-bottom: 20px;}

    .form_request .form-group{margin-bottom: 20px;}
    .form_request .form-group p{margin-bottom: 10px;}
    .form_request .form-group p b{color: darkred;}

    @media (max-width: 1199.98px) {
        .account_info{flex-wrap: wrap;}
        .sidebar-menu,.account-main-section{width: 100%;margin-left: 0;margin-bottom: 20px;}
    }
</style>
