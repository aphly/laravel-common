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
        <ul>
            @foreach($res['list'] as $val)
            <li>
                <a href="/article/{{$val->id}}">
                    <div class="d-flex justify-content-between">
                        <div>{{$val->title}} </div>
                        <div style="color:#999;">{{$val->created_at}} </div>
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

</style>
<script>

</script>
@include('laravel-common-front::common.footer')
