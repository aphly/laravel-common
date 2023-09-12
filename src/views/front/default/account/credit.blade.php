@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<section class="">
    <div class="account container">
        <div class="confirmation container">
            @include('laravel-common-front::account.submenu')
        </div>

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

        <div class="credit2 _shadow" style="">
            <div class="credit21">
                <div class="credit21a"> Point Log</div>
            </div>
            <ul class="userCreditLog">
                @if($res['userCreditLog']->count())
                @foreach($res['userCreditLog'] as $val)
                    <li class="">
                        <div class="userCreditLog1a d-flex justify-content-between"><span>{{$val->key}}</span><span>{{$val->pre}}{{$val->val}}</span></div>
                        <div class="userCreditLog1b d-flex justify-content-between"><span>{{$val->type}}</span> <span>{{$val->created_at}}</span></div>
                    </li>
                @endforeach
                @endif
            </ul>
            <div >{{$res['userCreditLog']->links('laravel-common-front::common.pagination')}}</div>
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
                        Secure checkout experience provided by Stripe or PayPal. No payment method information is stored on {{config('common.hostname')}}.
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
    method_id = $('#payment_methods li.active').data('id')

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

function order(_this){
    $(_this).attr('disabled',true);
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
        },
        complete:function(XMLHttpRequest,textStatus){
            $(_this).removeAttr('disabled');
        }
    })
}
</script>
@include('laravel-common-front::common.footer')
