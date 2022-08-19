@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-common/css/account.css') }}">
<section class="">
    <div class="confirmation container">
        @include('laravel-common::front.account.submenu')
        @if($res['group']->count())
        <div>group {{$res['group'][$user->group_id]['name']}}</div>
        <div>
            <ul class="group_order">
                @foreach($res['group'] as $val)
                    @if($val->status==1 && $val->id>1)
                    <li >
                        <div>
                            {{$val->name}}
                        </div>
                        <div class="month">
                            <select data-price="{{$val->price}}">
                                <option value="1" selected>1</option>
                                <option value="3">3</option>
                                <option value="6">6</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="total">
                            {{$val->price}}
                        </div>
                        <div onclick="order({{$val->id}})">order</div>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div>
        <form action="/account/group" method="post">
            @csrf
            <input type="text" name="group_id" value="2">
            <input type="text" name="method_id" value="1">
            <input type="text" name="month" value="1">
            <input type="submit" value="submit">
        </form>
    </div>
</section>
<script>
let month=1;
$(function () {
    $('.group_order li').on('change','select',function () {
        console.log($(this).data('price'),$(this).val())
        let total = $(this).data('price')*$(this).val();
        $('.total').html('$ '+total)
        month = $(this).val();
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
