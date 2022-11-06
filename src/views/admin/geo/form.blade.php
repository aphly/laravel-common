
<div class="top-bar">
    <h5 class="nav-title">geo</h5>
</div>
<div class="imain">
    <form method="post" @if($res['geoGroup']->id) action="/common_admin/geo/save?id={{$res['geoGroup']->id}}" @else action="/common_admin/geo/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" required class="form-control " value="{{$res['geoGroup']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">描述</label>
                <input type="text" name="desc" class="form-control " value="{{$res['geoGroup']->desc}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['geoGroup']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group geo">
                <div onclick="geo_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> geo Values</div>
                <div class="add_div">
                    <ul class="add_div_ul">
                        <li class="d-flex">
                            <div class="geo1">Country</div>
                            <div class="geo2">Zone</div>
                        </li>
                        @if($res['geo'])
                            @foreach($res['geo'] as $key=>$val)
                                <li class="d-flex">
                                    <div class="geo1">
                                        <select name="value[{{$val->id}}][country_id]" onchange="changeCountry(this)" class="form-control ">
                                            @foreach($res['country'] as $v)
                                            <option value="{{$v['id']}}" @if($val->country_id==$v['id']) selected @endif >{{$v['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="geo2">
                                        <select name="value[{{$val->id}}][zone_id]" id="geo_{{$val->id}}" class="form-control ">
                                            <option value="0" @if(!$val->zone_id) selected @endif>All Zones</option>
                                            @foreach($res['country_zone'][$val->country_id] as $v)
                                                <option value="{{$v['id']}}" @if($val->zone_id==$v['id']) selected @endif>{{$v['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="geo3" onclick="geo_delDiv(this)"><i class="uni app-lajitong"></i></div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>
    .geo .geo1{width: 50%;margin: 5px 2%;}
    .geo .geo2{width: 30%;margin: 5px 2%;}
    .geo .geo3{display: flex;align-items: center;cursor: pointer;}
    .geo .geo3:hover{color: red;}
</style>
<script>
    function geo_addDiv() {
        let id = randomId(8);
        let html = `<li class="d-flex" data-id="${id}">
                        <div class="geo1">
                            <select name="value[${id}][country_id]" onchange="changeCountry(this)" class="form-control ">
                                @foreach($res['country'] as $v)
                                    <option value="{{$v['id']}}" >{{$v['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="geo2"><select name="value[${id}][zone_id]" id="geo_${id}" class="form-control "><option value="0">All Zones</option></select></div>
                        <div class="geo3" onclick="geo_delDiv(this)"><i class="uni app-lajitong"></i></div>
                    </li>`;
        $('.add_div ul').append(html);
    }
    function geo_delDiv(_this) {
        $(_this).parent().remove()
    }
    function changeCountry(_this) {
        let country_id = $(_this).val()
        let html=`<option value="0">All Zones</option>`;
        $.ajax({
            url:'/country/'+country_id+'/zone',
            dataType: "json",
            success: function(res){
                if(res.data){
                    for(let i in res.data){
                        html += `<option value="${res.data[i].id}">${res.data[i].name}</option>`;
                    }
                    $(_this).closest('.geo1').next().children('select').html(html);
                }
            }
        })

    }
</script>
