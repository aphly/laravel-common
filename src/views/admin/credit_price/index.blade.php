<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/common_admin/credit_price/index" class="select_form">
        <div class="search_box ">
            <select name="credit_key" >
                @foreach($res['credit_key'] as $val)
                    <option value="{{$val}}" @if($res['search']['credit_key']==$val) selected @endif>{{$val}}</option>
                @endforeach
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_html show_all0_btn" data-href="/common_admin/credit_price/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/common_admin/credit_price/del?{{$res['search']['string']}}" @else action="/common_admin/credit_price/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >积分名</li>
                    <li >数量</li>
                    <li >价格</li>
                    <li >sort</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v['credit_key'] }}</li>
                        <li>{{ $v['credit_val'] }}</li>
                        <li>{{ $v['price'] }}</li>
                        <li>
                            {{$v->sort}}
                        </li>
                        <li>
                            <a class="badge badge-info ajax_html" data-href="/common_admin/credit_price/form?id={{$v['id']}}">编辑</a>
                        </li>
                    </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li >
                            {{$res['list']->links('laravel::admin.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>


