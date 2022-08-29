<footer class="">
    <div class="container">
        <div class="footer1">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="d-flex justify-content-between footer2">
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
    footer{background: #fafafa;padding: 50px 0 20px;}
    .footer1{display: flex;}
    .footer2{padding: 20px 0 0;border-top: 1px solid #f1f1f1;color:#757575;}
    .footer2 a{color:#757575;}
</style>

<script src="{{ URL::asset('vendor/laravel-admin/js/bootstrap.bundle.min.js') }}"></script>
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
