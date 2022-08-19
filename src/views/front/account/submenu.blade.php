
<section class="">
    <div class=" container">
        <ul class="submenu">
            <li @if(request()->is('account/group')) class="active" @endif>VIP</li>
            <li @if(request()->is('account/credit')) class="active" @endif>POINT</li>
        </ul>
    </div>
</section>
