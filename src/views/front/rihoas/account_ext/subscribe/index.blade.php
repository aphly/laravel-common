@include('laravel-common-front::common.header')
<div class="container">
    <style>

    </style>
    <div class="d-flex justify-content-between account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Subscribe</h2>
                </div>
                <form method="post" action="/account_ext/subscribe" data-fn="subscribe_res" class="form_request">
                    @csrf
                    @if(!empty($res['info']))
                        <div>
                            <input type="radio" value="1" name="status" id="status1" @if($res['info']->status==1) checked @endif> <label for="status1">Yes</label>
                            <input type="radio" value="2" name="status" id="status2" @if($res['info']->status==2) checked @endif> <label for="status2">No</label>
                        </div>
                    @else
                        <div>
                            <input type="radio" value="1" name="status" id="status1"> <label for="status1">Yes</label>
                            <input type="radio" value="2" name="status" id="status2" checked> <label for="status2">No</label>
                        </div>
                    @endif
                    <button type="submit">save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function subscribe_res(res,form_class) {
        alert_msg(res)
    }
</script>
@include('laravel-common-front::common.footer')
