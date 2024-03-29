</main>
<footer>
    <div class="footer2">
        <div class="container">
            <div class="footer21">
                <div class="footer21a">
                    <div>
                        <i class="uni app-world"></i>
                    </div>
                    @if($currency[0] && $currency[1] && $currency[2])
                        <div class="currency_box">
                            <div class="currency_curr">
                                <div class="baCountry baCountry-{{$currency[2]['code']}}" style="display: none;"></div>
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
                    © {{date('Y')}} {{config('common.hostname')}}. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
</style>
<script src="{{ URL::asset('static/statistics/js/statistics.js') }}" data-appid="{{config('common.statistics_appid')}}" id="statistics"></script>
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
