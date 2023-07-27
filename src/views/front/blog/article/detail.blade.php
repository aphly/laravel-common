@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">

<section class="pt20">
    <div class="news container">
        <div class="d-flex all_breadcrumb">
            <a href="{{url('/')}}"><span>Home</span></a>
            @foreach($res['paths'] as $val)
                <a href="/article/index?category_id={{$val['category_p']['id']}}"><span style="margin:0 5px;">></span><span>{{$val['category_p']['name']}}</span></a>
            @endforeach
            <a href="{{url('/article/'.$res['info']->id)}}"><span style="margin:0 5px;">></span><span>{{$res['info']->title}}</span></a>
        </div>
        <div class="title">{{$res['info']->title}}</div>
        <div class="" style="color: #999;margin-bottom: 20px;font-size: 12px;">{{$res['info']->created_at}}</div>
        <div class="content">
            {!! $res['info']->content !!}
        </div>
    </div>
</section>

<style>
    .news .title{margin-bottom: 10px;font-size: 20px;font-weight: 600}
    .news{margin-bottom: 50px}
    .content{max-width: 100%;word-wrap: break-word;}
</style>
<script>
</script>
@include('laravel-common-front::common.footer')
