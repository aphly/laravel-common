@include('laravel-common::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/common/css/account.css') }}">
<section class="">
    <div class="confirmation container">
        {{$res['msg']}}
    </div>
</section>
<script>

</script>
@include('laravel-common::front.common.footer')
