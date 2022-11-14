
<section class="">
    <div class=" container">
        <ul class="submenu">
            <a href="/account/index"><li @if(request()->is('account/index')) class="active" @endif>Profile</li></a>
            <a href="/account/group"><li @if(request()->is('account/group')) class="active" @endif>VIP</li></a>
            <a href="/account/credit"><li @if(request()->is('account/credit')) class="active" @endif>POINT</li></a>
            <a href="/account/setting" class="d-none"><li @if(request()->is('account/setting')) class="active" @endif>Setting</li></a>
        </ul>
    </div>
</section>
<style>
   .submenu{display: flex;justify-content:center;line-height: 47px;border-bottom:1px solid #f1f1f1;}
   .submenu li.active{border-bottom: 3px solid #007aff}
   .submenu li{font-size: 20px;padding:0 10px;margin: 0 15px;}
   .submenu a {color:#333;font-weight: 600;}
   @media (max-width: 1199.98px) {
       .submenu li{padding: 0;}
   }
</style>
