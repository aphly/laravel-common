
<div class="top-bar">
    <h5 class="nav-title">文章</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/common_admin/news/save?id={{$res['info']->id}}" @else action="/common_admin/news/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">标题</label>
                <input type="text" name="title" required class="form-control " value="{{$res['info']->title}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group d-none" >
                <label for="">内容</label>
                <textarea name="content" id="content" class="form-control ">{{$res['info']->content}}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group ">
                <label for="">内容</label>
                <div id="editor—wrapper" style="z-index: 10">
                    <div id="editor-toolbar"></div>
                    <div id="editor-container"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="">文章分类</label>
                <div style="position: relative" id="category_select">
                    <input type="hidden" name="news_category_id"  class="form-control category_select_value" value="{{$res['info']->news_category_id??0}}">
                    <input type="text" class="form-control category_select_name" readonly value="{{$res['category_select_name']}}">
                    <div class="tree_p">
                        <div class="treeview"></div>
                    </div>
                </div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group" id="status">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">查看数</label>
                <input type="number" name="viewed" class="form-control " value="{{$res['info']->viewed??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

<style>
    .tree_p{position: absolute;left:0;top:34px;display:none;width: 100%;background: #fff;box-shadow: 0 1px 4px rgb(24 38 16 / 10%);}
</style>

<script>
    var treeGlobal = {
        list : @json($res['newsCategory']),
        select_ids:@json($res['select_ids']),
    }
    treeGlobal.data = toTree(selectData(treeGlobal.list,treeGlobal.select_ids));

    function mount() {
        $('#category_select .treeview').treeview({
            levels: 2,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            data:treeGlobal.data,
            onNodeSelected: function(event, data) {
                $('#category_select .category_select_name').val(data.text)
                $('#category_select .category_select_value').val(data.id)
                $('#category_select .tree_p').hide();
            },
            onNodeUnselected: function(event, data) {
                $('#category_select .category_select_name').val('')
                $('#category_select .category_select_value').val(0)
                $('#category_select .tree_p').hide();
            },
        });
        $('#category_select').on('click','.category_select_name',function (e) {
            e.preventDefault()
            e.stopPropagation()
            $(this).next().toggle();
        })
        $('body').off('click').on("click", function (e) {
            if (e.target.className !== 'tree_p' || e.target.className !== 'category_select_name') {
                $('#category_select .tree_p').hide();
            }
        });
    }
    $(function () {
        const { createEditor, createToolbar } = window.wangEditor
        const editorConfig = {
            onChange(editor) {
                $('#content').html(editor.getHtml());
            },
            MENU_CONF: {}
        }
        editorConfig.MENU_CONF['uploadImage'] = {
            server: '/news/img',
            fieldName: 'newsImg',
            maxFileSize: 1*1024*1024,
            maxNumberOfFiles: 10,
            allowedFileTypes: ['image/*'],
            meta: {
                _token: '{{csrf_token()}}'
            },
            metaWithUrl: true,
            withCredentials: false,
            timeout: 5 * 1000,
        }
        const editor = createEditor({
            selector: '#editor-container',
            html: '{!! $res['info']->content !!}',
            config: editorConfig,
            mode: 'simple',
        })
        const toolbarConfig = {}
        const toolbar = createToolbar({
            editor,
            selector: '#editor-toolbar',
            config: toolbarConfig,
            mode: 'simple',
        })
        mount()
    })

</script>
