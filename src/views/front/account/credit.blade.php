@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<section class="">
    <div class="account container">

        <div class="confirmation container">
            @include('laravel-common::front.account.submenu')
        </div>
        <style>
            .credit1{padding: 20px 0;font-weight: 600;text-align: center;}
            .credit11{font-size: 32px;}
            .credit12{font-size: 26px;}
            .credit12 i{font-size: 26px;position: relative;top: 1px;}

            .credit2{border-radius: 10px;padding: 16px 0;}
            .credit21a{font-weight: 600;font-size: 20px;}
            .credit21a i{font-weight: 600;font-size: 20px;}
            .credit21b{font-size: 12px;font-weight: 600;color: #888888;}
            .credit21,.credit_price{padding: 0 16px;}
            .credit21{padding-bottom: 10px;border-bottom:1px solid #f1f1f1; }
            .credit_price li{padding-bottom: 16px;padding-top: 16px;border-bottom:1px solid #f1f1f1;}
            .credit_price1{font-weight: 600;}
            .credit_price1a{font-size: 20px;}
            .credit_price1a i{font-size: 20px;}
            .credit_price1b{color: #888;}
            .credit_price1c{font-size: 13px;}

        </style>
        <div class="credit1">
            <div class="credit11">My Point</div>
            <div class="credit12">
                 <i class="common-iconfont icon-jifen-xianxing2-0"></i> {{$res['userCredit']->point}}
            </div>
        </div>
        <div class="credit2 _shadow">
            <div class="credit21">
                <div class="credit21a"><i class="common-iconfont icon-jifen-xianxing2-0"></i> Point</div>
                <div class="credit21b">Purchase Point.</div>
            </div>
            <ul class="credit_price">
                @foreach($res['creditPrice'] as $val)
                <li class="d-flex justify-content-between">
                    <div class="credit_price1">
                        <div class="credit_price1a"><i class="common-iconfont icon-jifen-xianxing2-0"></i> {{$val->credit_val}} </div>
                        <div class="credit_price1b">{{$val->credit_key}}</div>
                        <div class="credit_price1c">${{$val->price}}</div>
                    </div>
                    <div class="credit_price2" >
                        <div class="buleBtn bowen" onclick="_confirm({{$val->id}},this)" data-price="{{$val->price}}" data-key="{{$val->credit_key}}" data-val="{{$val->credit_val}}">BUY</div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <style>
            .userCreditLog li{padding: 16px; border-bottom: 1px solid #f1f1f1;}
            .userCreditLog li .userCreditLog2{color:#999;}
            .userCreditLog1{font-weight: 600;}
            .userCreditLog1a{font-size: 18px;}
            .userCreditLog1b span{margin-left: 5px;}
        </style>
        <div class="credit2 _shadow" style="margin-top: 20px;">
            <div class="credit21">
                <div class="credit21a"> Point Log</div>
            </div>
            <ul class="userCreditLog">
                @foreach($res['userCreditLog'] as $val)
                    <li class="d-flex justify-content-between">
                        <div class="userCreditLog1">
                            <p class="userCreditLog1a">{{$val->type}}</p>
                            <p class="userCreditLog1b">{{$val->key}}<span>{{$val->pre}}{{$val->val}}</span></p>
                        </div>
                        <div class="userCreditLog2">
                            {{$val->created_at}}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<section>
    <div class="modal fade" id="checkout" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Get more Point</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="checkout1">
                        <div class="checkout11">Your selection</div>
                        <div class="d-flex justify-content-between confirm">
                            <div class="confirm0">
                                <div class="confirm1"><i class="common-iconfont icon-jifen-xianxing2-0"></i><span></span></div>
                                <div class="confirm2"></div>
                            </div>
                            <div class="total"></div>
                        </div>
                    </div>
                    <div class="checkout2">
                        <div class="method1">Payment Methods</div>
                        <div class="method2">
                            @if($res['method']->count())
                            <ul id="payment_methods">
                                @foreach($res['method'] as $val)
                                <li data-id="{{$val->id}}">
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
                    <div class="checkout4">
                        <button type="button" class="buleBtn" onclick="order()">BUY</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
let credit_price_id;
let method_id=1;
$(function () {

    $('.credit_price').on('click','li',function () {
        $('.credit_price li').not($(this)).removeClass('active')
        $(this).addClass('active')
    })

    $('#payment_methods').on('click','li',function () {
        $('.method2 li').removeClass('active')
        $(this).addClass('active')
        method_id = $(this).data('id')
    })

})

function _confirm(id,_this) {
    credit_price_id = id;
    $('.checkout1 .confirm .confirm1 span').html($(_this).data('val'))
    $('.checkout1 .confirm .confirm2 ').html($(_this).data('key'))
    $('.checkout1 .confirm .total').html('$'+$(_this).data('price'))
    $('#checkout').modal('show')
}

function order(){
    $.ajax({
        url:'/account/credit',
        type:'post',
        dataType: "json",
        data: {credit_price_id,method_id,'_token':'{{csrf_token()}}'},
        success:function (res) {
            if(!res.code){
                location.href=res.data.redirect
            }else{
                alert_msg(res)
            }
        }
    })
}
</script>
@include('laravel-common::front.common.footer')
