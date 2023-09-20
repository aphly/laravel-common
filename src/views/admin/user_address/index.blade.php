<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/common_admin/user_address/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="uuid" placeholder="uuid" value="{{$res['search']['uuid']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_html show_all0_btn " data-href="/common_admin/user_address/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/common_admin/user_address/del?{{$res['search']['string']}}" @else action="/common_admin/user_address/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >uuid</li>
                    <li >firstname</li>
                    <li >lastname</li>
                    <li >telephone</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v->uuid }}</li>
                        <li>
                            {{$v->firstname}}
                        </li>
                        <li>
                            {{$v->lastname}}
                        </li>
                        <li>
                            {{$v->telephone}}
                        </li>
                        <li>
                            <a class="badge badge-info ajax_html" data-href="/common_admin/user_address/form?id={{$v['id']}}">编辑</a>
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


