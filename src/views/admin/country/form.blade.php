
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/common_admin/country/save?id={{$res['info']->id}}" @else action="/common_admin/country/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">iso_code_2</label>
                <input type="text" name="iso_code_2" class="form-control " value="{{$res['info']->iso_code_2}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">iso_code_3</label>
                <input type="text" name="iso_code_3" class="form-control " value="{{$res['info']->iso_code_3}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">address_format</label>
                <input type="text" name="address_format" class="form-control " value="{{$res['info']->address_format}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">postcode_required</label>
                <select name="postcode_required" class="form-control">
                    @if(isset($dict['yes_no']))
                        @foreach($dict['yes_no'] as $key=>$val)
                            <option value="{{$key}}" @if($res['info']->postcode_required==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['info']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>

</style>
<script>

</script>
