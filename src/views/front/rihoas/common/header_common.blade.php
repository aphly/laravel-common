<!DOCTYPE html>
<html style="font-size: 14px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{$res['title']??''}} {{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="{{ URL::asset('static/base/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/base/css/c.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/base/css/iconfont.css') }}">
    <script src='{{ URL::asset('static/base/js/jquery.min.js') }}' type='text/javascript'></script>
    <script src="{{ URL::asset('static/base/js/jquery.lazyload.min.js') }}" type="text/javascript"></script>
    <script src='{{ URL::asset('static/base/js/c.js') }}' type='text/javascript'></script>
    <script src='{{ URL::asset('static/common/js/common.js') }}' type='text/javascript'></script>
    <link rel="stylesheet" href="{{ URL::asset('static/base/css/viewer.min.css') }}">
    <script src="{{ URL::asset('static/base/js/viewer.min.js') }}" type="text/javascript"></script>
    <meta name="description" content="{{$res['description']??''}}" />
    <script src='{{ URL::asset('static/base/js/decimal.js') }}' type='text/javascript'></script>
</head>
<body>
<style>

</style>
<script>
    $(function () {
        $('input.form-control').attr("autocomplete","off")
    })
</script>
