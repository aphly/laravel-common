@include('laravel-common-front::common.header')
<div class="container">
    <style>
        .address_info{margin-bottom: 0px;}
        .address_info span{font-weight: 600;margin-left: 10px;}
        .address_info p{margin-bottom: 5px;}
        .address_info i{font-style: normal;width: 100px;display: inline-block}
        .address_infox i{margin-right: 5px;}
        .address_infox a{color:#06b4d1;margin-right: 20px;}
    </style>
    <div class="d-flex justify-content-between account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Shipping Address</h2>
                    <a href="/account_ext/address/save">+ Add Address</a>
                </div>
                <ul class="list_index">
                    @foreach($res['list'] as $val)
                    <li class="">
                        <div class="d-flex justify-content-between">
                            <div class="address_info">
                                <p><i>Name:</i> <span>{{$val['firstname']}} {{$val['lastname']}}</span></p>
                                <p><i>Address:</i> <span>{{$val['address_1']}} , {{$val['city']}} , {{$res['zone'][$val['zone_id']]['name']}} , {{$res['country'][$val['country_id']]['name']}}</span></p>
                                <p><i>Postcode:</i> <span>{{$val['postcode']}}</span></p>
                                <p><i>Telephone:</i> <span>{{$val['telephone']}}</span></p>
                            </div>
                            <div class="">
                                @if($user->address_id == $val['id'])
                                    <span class="badge badge-success">default</span>
                                @endif
                            </div>
                        </div>
                        <div class="address_infox">
                            <a href="/account_ext/address/save?address_id={{$val['id']}}" >
                                <i class="common-iconfont icon-bianjishuru"></i>Edit
                            </a>
                            <a href="javascript:;" data-address_id="{{$val['id']}}" class="delete">
                                <i class="common-iconfont icon-shanchu"></i>Remove
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div>
                    {{$res['list']->links('laravel-common-front::common.pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function () {
    $('.list_index').on('click','.delete',function () {
        if(isDel()){
            let id = $(this).data('address_id')
            if(id){
                $.ajax({
                    url:'/account_ext/address/'+id+'/remove',
                    dataType:'json',
                    success:function (res) {
                        if(!res.code) {
                            location.href = res.data.redirect
                        }else{
                            alert_msg(res)
                        }
                    }
                })
            }
        }
    })
})
</script>
@include('laravel-common-front::common.footer')
