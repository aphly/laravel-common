@include('laravel-common-front::common.header')

<div class="container">
    <div class="d-flex justify-content-between account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2 class="">
                        Address
                    </h2>
                </div>
                <div class="form-info">
                    <form method="post" action="/account_ext/address/save?address_id={{request()->query('address_id')??0}}" class="form_request" data-fn="saveAddress">
                        @csrf
                        <input type="hidden" name="address_id" value="{{request()->query('address_id')??0}}">
                        <div class="form-group">
                            <p>First Name: <b>*</b></p>
                            <input type="text" name="firstname" required value="{{$res['info']->firstname}}" placeholder="First Name" class="form-control" >
                        </div>
                        <div class="form-group">
                            <p>Last Name: <b>*</b></p>
                            <input type="text" name="lastname" required value="{{$res['info']->lastname}}" placeholder="Last Name" class="form-control">
                        </div>

                        <div class="form-group">
                            <p>Address Line1: <b>*</b></p>
                            <input required name="address_1" type="text" class="form-control address1" value="{{$res['info']->address_1}}" placeholder="Address 1" >
                        </div>
                        <div class="form-group">
                            <div class=" ">
                                <p>Address Line2: </p>
                                <input name="address_2" type="text" class="form-control address2" value="{{$res['info']->address_2}}" placeholder="Address 2">
                            </div>
                        </div>
                        <div class="form-group">
                            <p>City: <b>*</b></p>
                            <input required name="city" type="text" class="form-control city" value="{{$res['info']->city}}" placeholder="City" >
                        </div>
                        <div class="form-group">
                            <p>Post Code: <b>*</b></p>
                            <input required name="postcode" value="{{$res['info']->postcode}}" placeholder="Post Code" type="text" class="form-control postcode">
                        </div>
                        <div class="form-group">
                            <p>Country: <b>*</b></p>
                            <select name="country_id" id="input-country" required class="form-control country">
                                <option value=""> --- Please Select --- </option>
                                @foreach($res['country'] as $val)
                                    <option value="{{$val['id']}}" @if($val['id']==$res['info']->country_id) selected @endif>{{$val['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group is-valid">
                            <p>State / Province: <b>*</b></p>
                            <select name="zone_id" required id="input-zone" class="form-control country ">
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
                        <div class="form-group">
                            <p>Telephone:</p>
                            <input name="telephone" type="text" class="form-control" placeholder="Telephone" value="{{$res['info']->telephone}}">
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="default" value="1" @if($user->address_id == $res['info']->id) checked="checked" @endif>
                            <span>Set as primary address</span>
                        </div>
                        <div class="form-group d-flex">
                            <button class="btn-default  save-address" >Save</button>
                            <a href="/account_ext/address" class="btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .save-address{background-color: #06b4d1;color: #fff;border: none;width: 120px;height: 40px;}
    .btn-cancel{background-color: #fff;border: 1px solid #333;width: 120px;height: 40px;margin-left: 40px;display: block;line-height: 40px;text-align: center;}
</style>
<script>
    function saveAddress(res) {
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
    let country_zone = {};
    $(function () {
        $('#input-country').change(function () {
            let country_id = $(this).val();
            if(country_id in country_zone){
                makeZone(country_zone[country_id])
            }else{
                if(country_id){
                    $.ajax({
                        url:'/country/'+country_id+'/zone',
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
