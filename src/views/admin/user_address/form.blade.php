
<div class="top-bar">
    <h5 class="nav-title">user address</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/common_admin/user_address/save?id={{$res['info']->id}}" @else action="/common_admin/user_address/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">id</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->id??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">uuid</label>
                <input type="text" name="uuid" required class="form-control " value="{{$res['info']->uuid??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">firstname</label>
                <input type="text" name="firstname" class="form-control " value="{{$res['info']->firstname??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">lastname</label>
                <input type="text" name="lastname" class="form-control " value="{{$res['info']->lastname??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">address_1</label>
                <input type="text" name="address_1" required class="form-control " value="{{$res['info']->address_1??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">address_2</label>
                <input type="text" name="address_2" class="form-control " value="{{$res['info']->address_2??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">city</label>
                <input type="text" name="city" class="form-control " value="{{$res['info']->city??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">postcode</label>
                <input type="text" name="postcode" class="form-control " value="{{$res['info']->postcode??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">telephone</label>
                <input type="text" name="telephone" class="form-control " value="{{$res['info']->telephone??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">country</label>
                <select name="country_id" required id="input-country" class="form-control">
                    <option value=""> --- Please Select --- </option>
                    @foreach($res['country'] as $val)
                        <option value="{{$val['id']}}" @if($val['id']==$res['info']->country_id) selected @endif>{{$val['name']}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">zone</label>
                <select name="zone_id" required id="input-zone" class="form-control">
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
                <label for="">created_at</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->created_at??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">updated_at</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->updated_at??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>

</style>
<script>
    var country_zone = {};
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
