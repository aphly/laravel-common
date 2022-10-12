
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
                <input type="hidden" name="news_category_id"  class="form-control" value="{{$res['info']->news_category_id}}">
                <input type="text" id="p_name" class="form-control" value="" onclick="mytoggle(this)" readonly>
                <div id="tree_p" style="position: absolute;display: none;width: 100%;background: #fff;box-shadow: 0 1px 4px rgb(24 38 16 / 10%);">
                    <div id="tree" class="treeview"></div>
                </div>
                <div style="position: relative">
                    <div></div>
                    <div id="tree" class="treeview"></div>
                </div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group" id="status">
                <label for="">状态</label>
                <select name="module_id" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key==$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">查看数</label>
                <input type="number" name="viewed" class="form-control " value="{{$res['info']->view??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>



<script>
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

        let list = @json($res['newsCategory']);
        let data = toTree(selectData(list,false))
        $('#tree').treeview({
            levels: 2,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            data,
            onNodeSelected: function(event, data) {
                id = data.id
            },
            onNodeUnselected: function(event, data) {
                id = 0
            },
        });
    })
</script>
