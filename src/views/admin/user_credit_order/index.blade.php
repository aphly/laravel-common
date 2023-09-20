<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/common_admin/user_credit_order/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="uuid" placeholder="uuid" value="{{$res['search']['uuid']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_html show_all0_btn d-none" data-href="/common_admin/user_credit_order/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/common_admin/user_credit_order/del?{{$res['search']['string']}}" @else action="/common_admin/user_credit_order/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >credit_price_id</li>
                    <li >total</li>
                    <li >payment_id</li>
                    <li >status</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v['credit_price_id'] }}</li>
                        <li>
                            {{$v->total}}
                        </li>
                        <li>
                            {{$v->payment_id}}
                        </li>
                        <li>
                            @if($dict['payment_status'])
                                @if($v->status==2)
                                    <span class="badge badge-success">{{$dict['payment_status'][$v->status]}}</span>
                                @else
                                    <span class="badge badge-secondary">{{$dict['payment_status'][$v->status]}}</span>
                                @endif
                            @endif
                        </li>
                        <li>
                            <a class="badge badge-info ajax_html" data-href="/common_admin/user_credit_order/form?id={{$v['id']}}">编辑</a>
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


