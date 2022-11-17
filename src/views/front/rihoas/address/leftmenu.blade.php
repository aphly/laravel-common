<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/account.css') }}">
<div class="sidebar-menu" id="sidebar-menu">
    <div class="sidebar-menu-list js-sidebar-menu clearfix">
        <div class="sidebar-menu-title">My Account Information</div>
        <ul class="sidebar-menu-content">
            <li><a href="/customer/account" @if('customer/account'==request()->path()) class="current" @endif>Dashboard</a></li>
            <li class="none"><a href="index.php?route=account/account" class="current">My Try On</a></li>
            <li><a href="/customer/wishlist">My Wishlist</a></li>
        </ul>

        <div class="sidebar-menu-title">Order Details</div>
        <ul class="sidebar-menu-content">
            <li><a href="/customer/order">My Orders</a></li>
            <li><a href="/customer/address">My Address Book</a></li>
            <li class="none"><a href="/customer/account" class="current">Track My Order </a></li>
        </ul>
        <div class="sidebar-menu-title last-title">Customer Service</div>
        <div class="sidebar-menu-content last-content" style="">
            <span>Need help? We're here to help you:</span>
            <div class="phone">
                <b>{{ config('shop.email') }}</b> <br>
                <span>9:00 AM to 6:00 PM Mon to Fri. (EST)</span>
            </div>
        </div>

    </div>
</div>
