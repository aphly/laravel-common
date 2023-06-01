</main>
<footer>
    <div class="footer1">
        <div class="container">
            <div class="footer11">

                <ul>
                    <li>About Us</li>
                    <li><a href="">Terms of Service</a></li>
                    <li><a href="">Privacy Policy</a></li>
                </ul>
                <ul style="margin-right: auto">
                    <li>Support</li>
                    <li><a href="">Contact Us</a></li>
                    <li><a href="">Refund Policy</a></li>
                    <li><a href="">Shipping</a></li>
                </ul>
                <ul>
                    <li>Subscribe to our newsletter</li>
                    <li>A short sentence describing what someone will receive by subscribing</li>
                    <li>
                        <form data-fn="subscribe_res" class="form_request subscribe" action="/subscribe/ajax" method="post">
                            @csrf
                            <input type="text" name="email" autocomplete="off" placeholder="Your email">
                            <button type="submit" >Subscribe</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer2">
        <div class="container">
            <div class="footer21">
                <div class="footer21a">
                    @if($currency[0] && $currency[1] && $currency[2])
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
                            let currency_data = @json($currency[0]);
                            $(function () {
                                $('.currency_box .currency_curr').click(function () {
                                    $('.baDropdown').toggle();
                                })
                                $('.currency_box .baDropdown').on('click','li',function () {
                                    let id  =$(this).data('id')
                                    $.ajax({
                                        url:'/currency/'+id,
                                        dataType: "json",
                                        success: function(res){
                                            location.reload()
                                        }
                                    })
                                })
                            })
                        </script>
                    @endif
                </div>
                <div class="footer21b">
                    © {{date('Y')}} {{env('APP_NAME')}}, Inc.
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
    .subscribe{ display: flex;}
    .subscribe button,.subscribe input{border-radius: 4px;border: 1px solid #aaa}
    .subscribe input{padding: 0 10px;margin-right: 4px;}
    footer{}
    .footer1{background: #eaeaea;padding: 40px 0;}
    .footer11{display: flex;flex-wrap: wrap;}
    .footer21{display: flex;justify-content:space-between;line-height: 40px;}
    .footer11 ul{padding: 0 30px 30px 0;flex: 1;}
    .footer11 ul li{line-height: 34px;}
    .footer11 ul li:first-child{font-size: 22px;margin-bottom: 10px;font-weight: 600}
    .footer11 ul li:not(:first-child){font-size: 16px;}
    .footer11 ul:last-child{flex: 2;}
    .footer2{background: #e1e1e1;}

    .currency_box{position: relative;left: 0;bottom: 0;z-index: 1000;font-size: 14px;}
    .footer21a{display: flex;}
    .currency_box .currency_curr{background-color: transparent;box-shadow: none;}
    @media (max-width: 1199.98px) {
        .footer11 ul{flex-basis: 100%;}
    }

</style>

<script src="{{ URL::asset('static/base/js/bootstrap.bundle.min.js') }}"></script>
<script>
    var aphly_viewerjs = document.querySelectorAll('.aphly_viewer_js');
    if(aphly_viewerjs){
        aphly_viewerjs.forEach(function (item,index) {
            new Viewer(item,{
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
        })

    }
    function subscribe_res(res,_this) {
        alert_msg(res)
    }
    $(function() {
        $("img.lazy").lazyload({effect : "fadeIn",threshold :50});
    })
</script>
</body>
</html>
