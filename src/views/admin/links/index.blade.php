<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/common_admin/links/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="name" placeholder="link name" value="{{$res['search']['name']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_html show_all0_btn" data-href="/common_admin/links/tree">树</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/common_admin/links/del?{{$res['search']['string']}}" @else action="/common_admin/links/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >name</li>
                    <li >sort</li>
                    <li >状态</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{!! $v['name'] !!}</li>
                        <li>
                            {{$v['sort']}}
                        </li>

                        <li>
                            @if($dict['status'])
                                @if($v->status)
                                    <span class="badge badge-success">{{$dict['status'][$v->status]}}</span>
                                @else
                                    <span class="badge badge-secondary">{{$dict['status'][$v->status]}}</span>
                                @endif
                            @endif
                        </li>
{{--                            <a class="badge badge-info ajax_html" data-href="/common_admin/links/{{$v['id']}}/edit">编辑</a>--}}
                    </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li>
                            {{$res['list']->links('laravel::admin.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>


