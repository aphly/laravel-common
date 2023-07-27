@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<section class="pt20">
    <div class="news container">
        <div class="d-flex all_breadcrumb">
            <a href="{{url('/')}}"><span>Home</span></a>
            @foreach($res['paths'] as $val)
                <a href="/article/index?category_id={{$val['category_p']['id']}}"><span style="margin:0 5px;">></span><span>{{$val['category_p']['name']}}</span></a>
            @endforeach
        </div>
        @if(count($res['paths_child'])>1)
        <ul class="category">
            @foreach($res['paths_child'] as $val)
                @if($res['search']['category_id'] && $res['search']['category_id']!=$val['category_child']['id'])
                <li>
                    <a href="/article/index?category_id={{$val['category_child']['id']}}">
                        <div>{{$val['category_child']['name']}} </div>
                    </a>
                </li>
                @endif
            @endforeach
        </ul>
        @endif
        <ul class="article_list">
            @foreach($res['list'] as $val)
            <li>
                <a href="/article/{{$val->id}}">
                    <div class="">
                        <div style="font-size: 16px;font-weight: 600">{{$val->title}} </div>
                        <div style="color:#999;font-size: 12px;">{{$val->created_at}} </div>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
        <div>
            {{$res['list']->links('laravel-common-front::common.pagination')}}
        </div>
    </div>
</section>

<style>
    ul.category{display: flex;flex-wrap: wrap;margin-bottom: 20px;}
    ul.category li{width:23%;height: 100px;margin: 1%;background: #f1f1f1;border-radius: 8px; }
    ul.category li a{display: flex;align-items: center;justify-content: center;height: 100%;}
    .article_list{}
    .article_list li{height: 40px;margin-bottom: 10px;}
</style>
<script>

</script>
@include('laravel-common-front::common.footer')
