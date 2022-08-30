@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/account.css') }}">
<section class="">
    <div class=" container">
        @include('laravel-common::front.account.submenu')
    </div>
    <div class="group">
        <div class="my_group"> {{$res['group'][$user->group_id]['name']}}</div>
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
                            <div onclick="order({{$val->id}})" class="order">SUBSCRIBE</div>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
    <div class="checkout">
        <div></div>
    </div>
</section>
<style>
.my_group{margin-top: 20px;font-size: 32px;font-weight: 600;text-align: center;}
.group1{margin: 10px 0 30px;text-align: center;}
.group_order li{padding: 20px;width: 30%;border-radius: 4px;box-shadow: 0 1px 4px rgb(24 38 16 / 30%); }
.group_name{font-weight: 600;color:#007aff;}
.month_list select{height: 36px;width: 120px;border: 1px solid #ddd;border-radius: 4px;}
.total .price{font-size: 26px;color: #000;margin-right: 5px;}
.total_month{font-size: 13px;color: #666;}
.total{display: flex;align-items: center;font-weight: 600;margin: 10px 0;}
.group .order{cursor:pointer;height:32px;margin:30px auto 10px;line-height:32px;width: 100px;border-radius: 20px;background:linear-gradient(131.45deg,#20A7FE,#003AFF);text-align: center;color: #fff;}
</style>
<script>
let month=1;
$(function () {
    $('.group_order li').on('change','select',function () {
        let total = $(this).data('price')*$(this).val();
        $('.total .price').html('$ '+total)
        month = $(this).val();
        $('.total .month').html($(this).find("option:selected").text())
    })
})
function order(group_id){
    $.ajax({
        url:'/account/group',
        type:'post',
        dataType: "json",
        data: {group_id,'method_id':1,month,'_token':'{{csrf_token()}}'},
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
