@include('laravel-common-front::common.header')

<div class="container">
    <nav aria-label="breadcrumb" class="row col-12 mt-lg-3">
        <ol class="breadcrumb breadcrumb-wrapper col-12 m-0 pt-0 pb-0 font-14">
            <li class="breadcrumb-item"><a href="/index"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/account/account">Account</a></li>
            <li class="breadcrumb-item"><a href="/account/address">Address Book</a></li>
            <li class="breadcrumb-item"><a href="/account/address/add">Add Address</a></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between">
        @include('laravel-common-front::address.leftmenu')
        <div class="main-section">
            <div class="gs-account">
                <div class="top-desc text-left">
                    <h1 class="mb-5 d-lg-block d-none">
                        Edit Address
                    </h1>
                </div>
                <div class="account-info">
                    <form method="post" action="" id="address_form" class="form-horizontal bv-form address_form">
                        @csrf
                        <input type="hidden" name="address_id" value="{{request()->query('address_id')??0}}">
                        <div class="form-group">
                            <label class="col-12 col-lg-2">First Name: <b>*</b></label>
                            <div class="col-12 col-lg-9">
                                <input type="text" name="firstname" required="" value="{{$res['info']->firstname}}" placeholder="First Name" class="control" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 col-sm-9">
                                <p>Last Name: <b>*</b></p>
                                <input type="text" name="lastname" required="" value="{{$res['info']->lastname}}" placeholder="Last Name" class="control">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9">
                                <p>Address Line1: <b>*</b></p>
                                <input required="" name="address_1" type="text" class="control address1" value="{{$res['info']->address_1}}" placeholder="Address 1" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9">
                                <p>Address Line2: </p>
                                <input name="address_2" type="text" class="control address2" value="{{$res['info']->address_2}}" placeholder="Address 2">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9">
                                <p>City: <b>*</b></p>
                                <input required="" name="city" type="text" class="control city" value="{{$res['info']->city}}" placeholder="City" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9">
                                <p>Post Code: <b>*</b></p>
                                <input required="" name="postcode" value="{{$res['info']->postcode}}" placeholder="Post Code" type="text" class="control postcode">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 col-sm-9">
                                <p>Country: <b>*</b></p>
                                <select name="country_id" id="input-country" class="control country">
                                    <option value=""> --- Please Select --- </option>
                                    @foreach($res['country'] as $val)
                                        <option value="{{$val['id']}}" @if($val['id']==$res['info']->country_id) selected @endif>{{$val['name']}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group is-valid">
                            <div class="col-xs-12 col-sm-9">
                                <p>State / Province: <b>*</b></p>
                                <select name="zone_id" required="" id="input-zone" class="control country ">
                                    @if($res['zone'])
                                        <option value=""> --- Please Select --- </option>
                                        @foreach($res['zone'] as $val)
                                            <option value="{{$val['id']}}" @if($val['id']==$res['info']->zone_id) selected @endif>{{$val['name']}}</option>
                                        @endforeach
                                    @else
                                        <option value=""> --- None --- </option>
                                    @endif
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9">
                                <p>Telephone: <b>*</b></p>
                                <input required="" name="telephone" type="text" class="control " placeholder="Telephone" value="{{$res['info']->telephone}}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-9">
                                <input type="checkbox" name="default" value="1" @if($res['customer']['address_id'] == $res['info']->id) checked="checked" @endif> Set as
                                primary address
                            </div>
                        </div>

                    </form>
                    <div class="form-group">
                        <div class="col-xs-12 col-sm-9">
                            <button id="save-address" class="btn-default w120" onclick="saveAddress()">Save</button>
                            <a href="/customer/address">
                                <button type="button" class="btn-primary w120 ml30 btn-cancel">Cancel</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function saveAddress() {
        let url = '/customer/address/save?address_id={{request()->query('address_id')??0}}';
        $.ajax({
            url,
            dataType:'json',
            type:'post',
            data:$('#address_form').serialize(),
            success:function (res) {
                if(!res.code) {
                    location.href = res.data.redirect
                }else if(res.code===11000){
                    for(var item in res.data){
                        let str = ''
                        res.data[item].forEach((elem, index)=>{
                            str = str+elem+'<br>'
                        })
                        let obj = $('#login input[name="'+item+'"]');
                        obj.removeClass('is-valid').addClass('is-invalid');
                        obj.next('.invalid-feedback').html(str);
                    }
                }else{
                    alert_msg(res)
                }
            }
        })
    }
    let country_zone = {};
    $(function () {
        $('#input-country').change(function () {
            let country_id = $(this).val();
            if(country_id in country_zone){
                makeZone(country_zone[country_id])
            }else{
                if(country_id){
                    $.ajax({
                        url:'/common/country/'+country_id+'/zone',
                        dataType: "json",
                        success: function(res){
                            country_zone[country_id] = res.data;
                            makeZone(country_zone[country_id])
                        }
                    })
                }else{
                    let html = '<option value=""> --- None --- </option>';
                    $('#input-zone').html(html)
                }
            }
        })
    })
    function makeZone(data){
        let html = '<option value=""> --- Please Select --- </option>';
        for(let i in data){
            html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
        }
        $('#input-zone').html(html)
    }
</script>
@include('laravel-common-front::common.footer')
