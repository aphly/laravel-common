@include('laravel-common-front::common.header')
<div class="container">
    <nav aria-label="breadcrumb" class="row col-12 mt-lg-3">
        <ol class="breadcrumb breadcrumb-wrapper col-12 m-0 pt-0 pb-0 font-14">
            <li class="breadcrumb-item"><a href="/index"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/account/account">Account</a></li>
            <li class="breadcrumb-item"><a href="/account/address">Address Book</a></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between">
        @include('laravel-common-front::address.leftmenu')
        <div class="main-section">
            <div class="gs-account">
                <div class="top-desc text-left">
                    <h1 class="d-flex justify-content-between">
                        Shipping Address
                        <span class="pull-right h1-action"><a href="/customer/address/save"><i class="fa fa-plus"></i> Add Address</a></span>
                    </h1>
                </div>
                <div class="row account-info address_list">
                    @foreach($res['list'] as $val)
                    <div class="col-12 mt-5">
                        <p class="address-name">Name: {{$val['firstname']}} {{$val['lastname']}} @if($res['customer']['address_id'] == $val['id']) <span class="badge badge-success pull-right">default</span> @endif</p>

                        <p class="col01">
                            <a href="javascript:;" data-address_id="{{$val['id']}}" class="delete ml-5">
                                <i class="fa fa-trash"></i> Remove
                            </a>
                        </p>
                    </div>
                    @endforeach
                </div>
                <div>
                    {{$res['list']->links('laravel-common-front::common.pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function () {
    $('.address_list').on('click','.delete',function () {
        let id = $(this).data('address_id')
        $.ajax({
            url:'/customer/address/remove/'+id,
            dataType:'json',
            success:function (res) {
                if(!res.code) {
                    location.href = res.data.redirect
                }else{
                    alert_msg(res)
                }
            }
        })
    })
})
</script>
@include('laravel-common-front::common.footer')
