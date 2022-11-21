</main>
<footer class="">

</footer>
<style>

    @media (max-width: 1199.98px) {

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
                    //console.log(res);
                    location.reload()
                    //alert_msg(res,true)
                }
            })
        })
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
