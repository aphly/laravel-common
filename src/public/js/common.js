$(function () {
    $("body").on('submit','.form_request',function (){
        let form_class = '.form_request';
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
                        window[fn](res,form_class);
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

function isDel() {
    let msg = "Are you really sure you want to delete it?";
    if(confirm(msg)==true){
        return true;
    }else{
        return false;
    }
}

let currency = {
    format(val,symbol_left='',symbol_right=''){
        let str='';
        if(symbol_left){
            str += symbol_left;
        }
        str +=val;
        if(symbol_right){
            str += symbol_right;
        }
        return str;
    }
}
