
    <div style="border-top: 1px solid #C6C6C6;margin: 20px 0;"></div>
    <div style="font-size: 12px;">
        <ul style="list-style: none;display: flex;padding: 0 0px;font-size: 12px;">
            <li ><a style="" href="{{url('/information/1')}}">About Us</a></li>
            <li style="margin: 0 10px;color: #999;">|</li>
            <li ><a style="" href="{{url('/account_ext/order')}}">My Order</a></li>
            <li style="margin: 0 10px;color: #999;">|</li>
            <li><a style="" href="{{url('/account_ext/service')}}">My Service</a></li>
        </ul>
        <div style="margin-top: 10px;">
            If you have any questions, please <a href="{{url('/contact_us')}}" style="color: #333;">contact us</a> or <a
                href="mailto:{{config('common.email')}}" style="color: #333;">{{config('common.email')}}</a> through our customer support page.
        </div>

        <div style="margin-top: 10px;">
            © {{date('Y')}} <a href="{{url('')}}" style="color: #333;">{{config('common.name')}}</a> All Rights Reserved.
        </div>
    </div>
</div>
</div>
