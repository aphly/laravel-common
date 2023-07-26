@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<section class="pt20">
    <div class="news container">
        <ul>
            @foreach($res['list_tree'] as $val)
            <li>
                <a href="/article/index?category_id={{$val['id']}}">
                    <div>{{$val['name']}} </div>
                </a>
            </li>
            @endforeach
        </ul>

    </div>
</section>

<style>
ul{display: flex;flex-wrap: wrap}
ul li{width:23%;height: 100px;margin: 1%;background: #f1f1f1;border-radius: 8px; }
ul li a{display: flex;align-items: center;justify-content: center;height: 100%;}
</style>
<script>

</script>
@include('laravel-common-front::common.footer')
