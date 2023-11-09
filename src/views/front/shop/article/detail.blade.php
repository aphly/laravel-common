@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">

<section class="pt20">
    <div class="news container">
        <div class="d-flex all_breadcrumb">
            <a href="{{url('/')}}"><span>Home</span></a>
            <i class="common-iconfont icon-xiangb"></i>
            <a href="{{url('/article/'.$res['info']->id)}}"><span>{{$res['info']->title}}</span></a>
        </div>
        <h1 class="">{{$res['info']->title}}</h1>
        <div class="" style="text-align: center;color: #999;margin-bottom: 20px;">{{$res['info']->created_at}}</div>
        <div class="content">
            {!! $res['info']->content !!}
        </div>
    </div>
</section>

<style>
    .news h1{margin-bottom: 10px;text-align: center;}
    .news{margin-bottom: 50px}
</style>
<script>

</script>
@include('laravel-common-front::common.footer')
