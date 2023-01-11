$(function () {
    $("body").on('submit','.form_request',function (){
        let form_class = '.form_request';
        const _this = $(this)
        const fn = _this.data('fn')
        if(_this[0].checkValidity()===false){
        }else{
            let url = _this.attr("action");
            let type = _this.attr("method");
            if(url && type && fn){
                $(form_class+' input.form-control').removeClass('is-valid').removeClass('is-invalid');
                let btn_html = $(form_class+' button[type="submit"]').html();
                $.ajax({
                    type,url,
                    data: _this.serialize(),
                    dataType: "json",
                    beforeSend:function () {
                        $(form_class+' button[type="submit"]').attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
                    },
                    success: function(res){
                        window[fn](res,_this);
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

    $("body").on('submit','.form_request_file',function (){
        const _this = $(this)
        let form_class = '.form_request_file';
        let formData = new FormData(_this[0]);
        // form.find('input[type="file"]').each(function () {
        //     for (let i = 0; i < $(this)[0].files.length; i++) {
        //         formData.append($(this).attr('name'), $(this)[0].files[i]);
        //     }
        // })
        let url = _this.attr("action");
        let type = _this.attr("method");
        const fn = _this.data('fn')
        if(_this[0].checkValidity()===false){
        }else {
            if (url && type) {
                $(form_class + ' input.form-control').removeClass('is-valid').removeClass('is-invalid');
                let btn_html = $(form_class + ' button[type="submit"]').html();
                $.ajax({
                    type, url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function () {
                        $(form_class + ' button[type="submit"]').attr('disabled', true).html('<i class="btn_loading app-jiazai uni"></i>');
                    },
                    success: function (res) {
                        window[fn](res, _this);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        $(form_class + ' button[type="submit"]').removeAttr('disabled').html(btn_html);
                    }
                })
            } else {
                console.log('no action' + url + type)
            }
        }
        return false;
    })

    $('body').on('click','.a_request',function (e) {
        e.preventDefault();
        let _this = $(this)
        let _token = _this.data('_token')
        let fn = _this.data('fn')
        let url = _this.attr('href')
        debounce_fn(function () {
            if(_token){
                $.ajax({
                    url,
                    type:'post',
                    data:_this.data(),
                    dataType: "json",
                    success:function (res) {
                        window[fn](res, _this);
                    }
                })
            }
        },400)
    })

    $('.form_input_file').on("change" , function(){
        let files = this.files;
        let length = files.length;
        let next_class = $(this).data('next_class')
        $('.'+next_class).html('')
        for( let i = 0 ; i < length ; i++ ){
            let fr = new FileReader(),
                img = document.createElement("img");
            fr.onload = function(e){
                img.src = this.result;
                $('.'+next_class).append(img)
            }
            fr.readAsDataURL(files[i]);
        }
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
