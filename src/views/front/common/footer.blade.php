<footer class="">
    <div class="container">
        <div class="footer1">
            <a href="/news/1"><div>About Us</div></a>
            <a href="/news/1"><div>Announcements</div></a>
            <a href="/news/1"> <div>Contact Us</div></a>
        </div>
        <div class="footer2 d-flex">
            <a href="/news/1"><i class="common-iconfont icon-facebook"></i></a>
            <a href="/news/1"><i class="common-iconfont icon-twitter"></i></a>
        </div>
        <div class="d-flex footer3">
            <div>Copyright © xxx {{date('Y')}}.</div>
            <div>
                <a href="/news/1"><span>Terms of Service</span></a>
                ·
                <a href="/news/1"><span>Privacy Policy</span></a>
                ·
                <a href="/news/1"><span>Cookie Policy</span></a>
            </div>
        </div>
    </div>
</footer>
<style>
    footer{background: #fafafa;padding: 50px 0 20px;margin-top: 20px;}
    .footer1{display: flex;flex-wrap: wrap;}
    .footer1 a{display: block;width: 100%;color: #555;font-weight: 600;margin-top: 15px;}
    .footer2{margin: 20px 0;}
    .footer2 i{font-size: 22px;margin-right: 10px;color: #555;}
    .footer3{padding: 20px 0 0;border-top: 1px solid #f1f1f1;color:#757575;justify-content: space-between}
    .footer3 a{color:#757575;}
    @media (max-width: 1199.98px) {
        .footer3{justify-content: initial;flex-wrap: wrap;}
        .footer3>div{width: 100%;margin-bottom: 10px;}
        .footer1{}
    }
</style>
@if($currency[0] && $currency[1] && $currency[2] && count($currency[0])>1 )
<div class="currency_box">
    <div class="currency_curr">
        <div class="baCountry baCountry-{{$currency[2]['code']}}"></div>
        <span class="ba-chosen ">{{$currency[2]['code']}}</span>
    </div>
    <ul class="baDropdown">
        @foreach($currency[0] as $val)
            <li class="currMovers @if($currency[2]['code']==$val['code']) active @endif" data-id="{{$val['id']}}">
                <div class="baCountry baCountry-{{$val['code']}}"></div>
                <span class="curChoice wenzi">{{$val['name']}} ({{$val['code']}})</span>
            </li>
        @endforeach
    </ul>
</div>

<script>

    function throttle(func, wait) {
        var context, args;
        var previous = 0;
        return function() {
            var now = +new Date();
            context = this;
            args = arguments;
            if (now - previous > wait) {
                func.apply(context, args);
                previous = now;
            }
        }
    }

    $(function () {
        $('.currency_box .currency_curr').click(function () {
            $('.baDropdown').toggle();
        })
        $('.currency_box .baDropdown').on('click','li',throttle(function () {
            console.log('zz');
            $.ajax({
                url:'/currency/'+id,
                dataType: "json",
                success: function(res){
                    console.log(res);
                    //alert_msg(res,true)
                }
            })
        }, 1000))
    })
</script>
@endif
<script src="{{ URL::asset('static/admin/js/bootstrap.bundle.min.js') }}"></script>
<script>
    var aphly_viewerjs = document.getElementById('aphly_viewerjs');
    if(aphly_viewerjs){
        var aphly_viewer = new Viewer(aphly_viewerjs,{
            url: 'data-original',
            toolbar:false,
            title:false,
            rotatable:false,
            scalable:false,
            keyboard:false,
            filter(image) {
                if(image.className.indexOf("aphly_viewer") !== -1){
                    return true;
                }else{
                    return false;
                }
            }
        });
    }
    $(function() {
        $("img.lazy").lazyload({effect : "fadeIn",threshold :50});
    })
</script>
</body>
</html>
