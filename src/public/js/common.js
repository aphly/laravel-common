let img_js_obj =  new img_js;
$(function () {
    $("body").on('submit','.form_request',function (){
        const that = $(this)
        const fn = that.data('fn')
        if(that[0].checkValidity()===false){
        }else{
            let url = that.attr("action");
            let type = that.attr("method");
            if(url && type && fn){
                that.find('input.form-control').removeClass('is-valid').removeClass('is-invalid');
                let btn_html = that.find('button[type="submit"]').html();
                $.ajax({
                    type,url,
                    data: that.serialize(),
                    dataType: "json",
                    beforeSend:function () {
                        that.find('button[type="submit"]').attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
                    },
                    success: function(res){
                        window[fn](res,that);
                    },
                    complete:function(XMLHttpRequest,textStatus){
                        that.find('button[type="submit"]').removeAttr('disabled').html(btn_html);
                    }
                })
            }else{
                console.log('no action')
            }
        }
        return false;
    })

    $("body").on('submit','.form_request_file',function (){
        const that = $(this)
        let formData = new FormData(that[0]);
        // form.find('input[type="file"]').each(function () {
        //     for (let i = 0; i < $(this)[0].files.length; i++) {
        //         formData.append($(this).attr('name'), $(this)[0].files[i]);
        //     }
        // })
        let url = that.attr("action");
        let type = that.attr("method");
        const fn = that.data('fn')
        if(that[0].checkValidity()===false){
        }else {
            if (url && type) {
                that.find('input.form-control').removeClass('is-valid').removeClass('is-invalid');
                let btn_html = that.find('button[type="submit"]').html();
                $.ajax({
                    type, url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function () {
                        that.find('button[type="submit"]').attr('disabled', true).html('<i class="btn_loading app-jiazai uni"></i>');
                    },
                    success: function (res) {
                        window[fn](res, that);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        that.find('button[type="submit"]').removeAttr('disabled').html(btn_html);
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
        let that = $(this)
        let _token = that.data('_token')
        let fn = that.data('fn')
        let url = that.attr('href')
        debounce_fn(function () {
            if(_token){
                $.ajax({
                    url,
                    type:'post',
                    data:that.data(),
                    dataType: "json",
                    success:function (res) {
                        window[fn](res, that);
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

    $("body").on('submit','.form_request_img_file',function (){
        let imgFileList = img_js_obj.imgFileList
        const that = $(this)
        let formData = new FormData(that[0]);
        for(let i in imgFileList){
            formData.append('files[image][]', imgFileList[i]);
        }
        let url = that.attr("action");
        let type = that.attr("method");
        const fn = that.data('fn')
        if(that[0].checkValidity()===false){
        }else {
            if (url && type) {
                that.find('input.form-control').removeClass('is-valid').removeClass('is-invalid');
                let btn_html = that.find('button[type="submit"]').html();
                $.ajax({
                    type, url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function () {
                        that.find('button[type="submit"]').attr('disabled', true).html('<i class="btn_loading app-jiazai uni"></i>');
                    },
                    success: function (res) {
                        window[fn](res, that);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        that.find('button[type="submit"]').removeAttr('disabled').html(btn_html);
                    }
                })
            } else {
                console.log('no action' + url + type)
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
    _format(val,symbol_left='',symbol_right=''){
        let str='';
        if(symbol_left){
            str += symbol_left;
        }
        str +=val;
        if(symbol_right){
            str += symbol_right;
        }
        return str;
    },
    format(val,code=''){
        for(let i in currency_data){
            if(currency_data[i].code==code){
                return this._format(val,currency_data[i].symbol_left,currency_data[i].symbol_right)
            }
        }
        return val;
    }
}
