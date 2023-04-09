@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<section class="">
    <div class="account container">
        @include('laravel-common-front::account.submenu')
    </div>
    <div class="group">
        <div class="my_group">
            <div class="my_group1">My Group</div>
            <div class="my_group2">
                <p>{{$res['group'][$user->group_id]['name']}}</p>
                @if($user->group_expire)
                <p class="expire">expire time: {{date('Y-m-d h:m:s',$user->group_expire)}}</p>
                @endif
            </div>
        </div>
        <div class="group1">Thank you for being a patron! Below is our full list of VIP perks:</div>
        <ul class="group_order d-flex justify-content-center">
            @if($res['group']->count())
                @foreach($res['group'] as $val)
                    @if($val->status==1 && $val->id>1)
                        <li>
                            <div class="group_name">
                                {{$val->name}}
                            </div>
                            <div class="group_desc">
                                {{$val->desc}}
                            </div>
                            <div class="total">
                                <span class="price">$ {{$val->price}}</span>
                                <span class="total_month"> / Per <span class="month">1 month</span> </span>
                            </div>
                            <div class="month_list">
                                <select data-price="{{$val->price}}">
                                    <option value="1" selected>1 month</option>
                                    <option value="3">3 months</option>
                                    <option value="6">6 months</option>
                                    <option value="12">1 year</option>
                                </select>
                            </div>
                            <div onclick="_confirm({{$val->id}},this)" data-price="{{$val->price}}" class="order">SUBSCRIBE</div>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>

</section>
<style>
.group{margin-bottom: 10px;}
.my_group{padding: 20px 0;font-weight: 600;text-align: center;}
.my_group1{font-size: 32px;}
.my_group2{font-size: 26px;}
.my_group2 .expire{font-size: 20px;color: #666;}
.group1{margin: 10px 0 30px;text-align: center;}
.group_order li{padding: 20px;width: 30%;border-radius: 4px;box-shadow: 0 1px 4px rgb(24 38 16 / 30%); }
.group_name{font-weight: 600;color:#007aff;}
.month_list select{height: 36px;width: 120px;border: 1px solid #ddd;border-radius: 4px;}
.total .price{font-size: 26px;color: #000;margin-right: 5px;}
.total_month{font-size: 13px;color: #666;}
.total{display: flex;align-items: center;font-weight: 600;margin: 10px 0;}
.group .order{cursor:pointer;height:32px;margin:30px auto 10px;line-height:32px;width: 100px;border-radius: 20px;background:linear-gradient(131.45deg,#20A7FE,#003AFF);text-align: center;color: #fff;}
</style>

<section>
    <div class="modal fade" id="checkout" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="checkout1">
                        <div class="checkout11">Your selection</div>
                        <div class="d-flex justify-content-between confirm">
                            <div class="confirm0">
                                <div class="confirm1">VIP (at <span></span>)</div>
                                <div class="confirm2">1 month</div>
                            </div>
                            <div class="total"></div>
                        </div>
                    </div>
                    <div class="checkout2">
                        <div class="method1">Payment Methods</div>
                        <div class="method2">
                            @if($res['method']->count())
                                <ul id="payment_methods">
                                    @foreach($res['method'] as $key=>$val)
                                        <li data-id="{{$val->id}}" @if(!$key) class="active" @endif>
                                            <div class="method2a"><img src="{{ URL::asset('static/payment/img/'.$val->name.'.png') }}" alt=""></div>
                                            <div class="method2b">{{$val->name}}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="checkout3">
                        Secure checkout experience provided by Stripe or PayPal. No payment method information is stored on {{env('APP_NAME')}}.
                    </div>
                    <label class="checkout0" for="agree">
                        <input type="checkbox" id="agree"> <span >I acknowledge that I have read and accept the <span>refund policy</span></span>
                    </label>
                    <div class="checkout4">
                        <button type="button" class="buleBtn" disabled onclick="order(this)">BUY</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .checkout0{color: #666;margin-top: 10px;}
    .checkout4 button:disabled{background: #999;}
    @media (max-width: 1199.98px) {
        .group_order li{width: 90%;}
    }
</style>
<script>
let month=1;
let method_id=1;
let group_id=2;
let month_html='1 month';
$(function () {
    method_id = $('#payment_methods li.active').data('id')
    $('.group_order li').on('change','select',function () {
        let total = $(this).data('price')*$(this).val();
        $('.total .price').html('$ '+total)
        month = $(this).val();
        month_html = $(this).find("option:selected").text();
        $('.total .month').html(month_html)
    })
    $('#payment_methods').on('click','li',function () {
        $('.method2 li').removeClass('active')
        $(this).addClass('active')
        method_id = $(this).data('id')
    })
    $('.checkout0').on('change','input',function (){
        if($(this).is(':checked')){
            $('.checkout4 button').removeAttr('disabled')
        }else{
            $('.checkout4 button').attr('disabled','disabled')
        }
    })
})

function _confirm(id,_this) {
    group_id = id;
    $('.checkout1 .confirm .confirm1 span').html('$'+$(_this).data('price')+' / month')
    $('.checkout1 .confirm .confirm2').html(month_html)
    $('.checkout1 .confirm .total').html('$'+$(_this).data('price')*month)
    $('#checkout').modal('show')
}

function order(_this){
    $(_this).attr('disabled',true);
    $.ajax({
        url:'/account/group',
        type:'post',
        dataType: "json",
        data: {group_id,method_id,month,'_token':'{{csrf_token()}}'},
        success:function (res) {
            if(!res.code){
                location.href=res.data.redirect
            }else{
                alert_msg(res)
            }
        },
        complete:function(XMLHttpRequest,textStatus){
            $(_this).removeAttr('disabled');
        }
    })
}
</script>
@include('laravel-common-front::common.footer')
