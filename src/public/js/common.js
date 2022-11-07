$(function () {
    $("body").on('submit','.save_form',function (){
        let form_class = '.save_form';
        const form = $(this)
        if(form[0].checkValidity()===false){
        }else{
            let url = form.attr("action");
            let type = form.attr("method");
            if(url && type){
                let btn_html = $(form_class+' button[type="submit"]').html();
                $.ajax({
                    type,url,data: form.serialize(),
                    dataType: "json",
                    beforeSend:function () {
                        $(form_class+' button[type="submit"]').attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
                    },
                    success: function(res){
                        if(!res.code) {
                            alert_msg(res,true)
                        }else if(res.code===11000){
                            form_err_11000(res,form_class);
                        }else{
                            alert_msg(res)
                        }
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
})
