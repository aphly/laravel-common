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
                    <div onclick="_confirm({{$val->id}},this)" data-price="{{$val->price}}">order</div>
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

<section>
    <div class="modal fade" id="Modal1" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Confirm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.credit_price li{}
.credit_price li.active{}

.modal{z-index: 1250;background: rgb(0 0 0 / 10%);}
.modal .modal-dialog{margin-top: 10%;}
</style>
<script>

$(function () {
    $('.credit_price').on('click','li',function () {
        $('.credit_price li').not($(this)).removeClass('active')
        $(this).addClass('active')
    })
})
let credit_price_id;
function _confirm(id,_this) {
    credit_price_id = id;
    //$(_this).data('price')
    $('#Modal1').modal('show')
}

function order(){
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
