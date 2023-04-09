@include('laravel-common-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">

<section class="">
    <div class="news container">
        <div class="d-flex news_breadcrumb">
            <a href="{{url('/')}}"><span>Home</span></a>
            <i class="common-iconfont icon-xiangb"></i>
            <a href="{{url('/news/'.$res['info']->id)}}"><span>{{$res['info']->title}}</span></a>
        </div>
        <h1 class="">{{$res['info']->title}}</h1>
        <div class="content">
            {!! $res['info']->content !!}
        </div>
    </div>
</section>

<style>
    .news_breadcrumb{margin-bottom: 30px;font-weight: 600;align-items: center;}
    .news_breadcrumb i{padding: 0 10px;font-size: 12px;}
    .news_breadcrumb .icon-xiangb{transform: rotate(270deg)}
    .news h1{margin-bottom: 20px;text-align: center;}
    .news{margin-bottom: 50px}
</style>
<script>

</script>
@include('laravel-common-front::common.footer')
