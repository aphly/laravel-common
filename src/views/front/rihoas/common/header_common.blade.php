<!DOCTYPE html>
<html style="font-size: 14px;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{$res['title']??''}} {{env('APP_NAME')}}</title>
    <link rel="stylesheet" href="{{ URL::asset('static/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/admin/css/c.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('static/admin/css/iconfont.css') }}">
    <script src='{{ URL::asset('static/admin/js/jquery.min.js') }}' type='text/javascript'></script>
    <script src="{{ URL::asset('static/admin/js/jquery.lazyload.min.js') }}" type="text/javascript"></script>
    <script src='{{ URL::asset('static/admin/js/c.js') }}' type='text/javascript'></script>
    <script src='{{ URL::asset('static/common/js/common.js') }}' type='text/javascript'></script>
    <link rel="stylesheet" href="{{ URL::asset('static/admin/css/viewer.min.css') }}">
    <script src="{{ URL::asset('static/admin/js/viewer.min.js') }}" type="text/javascript"></script>
    <meta name="description" content="{{$res['description']??''}}" />
</head>
<body>
<script>
    $(function (){
        let form_class = '.form_request'
        $(form_class).submit(function (){
            const form = $(this)
            const fn = form.data('fn')
            if(form[0].checkValidity()===false){
            }else{
                let url = form.attr("action");
                let type = form.attr("method");
                if(url && type && fn){
                    $(form_class+' input.form-control').removeClass('is-valid').removeClass('is-invalid');
                    let btn_html = $(form_class+' button[type="submit"]').html();
                    $.ajax({
                        type,url,
                        data: form.serialize(),
                        dataType: "json",
                        beforeSend:function () {
                            $(form_class+' button[type="submit"]').attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
                        },
                        success: function(res){
                            fn(res)
                        },
                        complete:function(XMLHttpRequest,textStatus){
                            $(form_class+' button[type="submit"]').removeAttr('disabled').html(btn_html);
                        }
                    })
                }else{
                    console.log('no action')
                }
            }
            return false;
        })
    });
</script>
