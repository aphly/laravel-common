@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/account.css') }}">
<section class="">
    <div class=" container">
        <div>point {{$res['userCredit']->point}}</div>
        <div class="confirmation container">
            @include('laravel-common::front.account.submenu')
        </div>

        <div>
            <ul class="credit_price">
                @foreach($res['creditPrice'] as $val)
                <li >
                    <div>
                        {{$val->credit_key}} {{$val->credit_val}} {{$val->price}}
                    </div>
                    <div onclick="order({{$val->id}})">order</div>
                </li>
                @endforeach
            </ul>
        </div>
        <div>
            <ul class="userCreditLog">
                @foreach($res['userCreditLog'] as $val)
                    <li >
                        <div>
                            <span>{{$val->pre}}</span><span>{{$val->key}}</span><span>{{$val->val}}</span>
                            <span>{{$val->type}}</span><span>{{$val->reason}}</span><span>{{$val->created_at}}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
<style>
.credit_price li{}
.credit_price li.active{}
</style>
<script>

$(function () {
    $('.credit_price').on('click','li',function () {
        $('.credit_price li').not($(this)).removeClass('active')
        $(this).addClass('active')
    })
})

function order(credit_price_id){
    $.ajax({
        url:'/account/credit',
        type:'post',
        dataType: "json",
        data: {credit_price_id,'method_id':1,'_token':'{{csrf_token()}}'},
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
