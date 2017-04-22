<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.news_list')}}"> Danh sách bài viết</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin bài viết @else Tạo mới bài viết @endif</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                {{Form::open(array('method' => 'POST', 'role'=>'form','files' => true))}}
                @if(isset($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p>{{ $itmError }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="form-group col-sm-4">
                    <label for="news_title"><i>Tiêu đề</i><span style="color: red"> *</span></label>
                    <input type="text" placeholder="Tên sản phẩm" id="news_title" name="news_title"
                           class="form-control input-sm"
                           value="@if(isset($data['news_title'])){{$data['news_title']}}@endif">
                </div>
                <div class="form-group col-sm-4">
                    <label for="topic_id"><i>Chuyên mục</i></label>
                    <select name="topic_id" id="topic_id" class="form-control input-sm">
                        <option value="0" @if(isset($data['topic_id']) && $data['topic_id'] == 0) selected="selected" @endif>Chuyên mục</option>
                        @foreach($topic as $k => $v)
                            <option value="{{$k}}" @if(isset($data['topic_id']) && $data['topic_id'] == $k) selected="selected" @endif>{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="news_status"><i>Trạng thái</i></label>
                    <select name="news_status" id="news_status" class="form-control input-sm">
                        <option value="1" @if(isset($data['news_status']) && $data['news_status'] == 1) selected="selected" @endif>Hiện</option>
                        <option value="0" @if(isset($data['news_status']) && $data['news_status'] == 0) selected="selected" @endif>Ẩn</option>
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label>Ảnh đại diện</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="news_image" name="news_image" accept="image/*">
                        <span data-title="Chọn ảnh đại diện" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 156px;height: 190px;padding: 2px;border: 1px solid gainsboro;display: none" class="news_image_preview">
                        <img src="" alt="" width="150" height="150">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 news_image_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i> Hủy
                            </button>
                        </div>
                    </div>
                    @if(isset($data['news_image']) && $data['news_image'] != '')
                        <div style="width: 156px;height: 156px;padding: 2px;border: 1px solid gainsboro" class="news_image_old">
                            <img src="{{Croppa::url(Constant::dir_news.$data['news_image'], 150, 150)}}" alt="" width="150" height="150">
                        </div>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <label>Bài viết</label>
                    <div class="clearfix"></div>
                    <div class="wysiwyg-editor" id="editor1">
                        @if(isset($data['news_content']))
                            {{htmlspecialchars_decode($data['news_content'])}}
                        @endif
                    </div>
                    <input type="hidden" id="news_content" name="news_content" @if(isset($data['news_content'])) value="" @endif>
                </div>
                <!-- PAGE CONTENT ENDS -->
                <div class="clearfix space-6"></div>
                <div class="form-group col-sm-12 text-right" style="margin-top: 30px">
                    <button  class="btn btn-primary sys_save_news"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
{{ HTML::script('assets/js/markdown.min.js'); }}
{{ HTML::script('assets/js/bootstrap-markdown.min.js'); }}
{{ HTML::script('assets/js/jquery.hotkeys.min.js'); }}
{{ HTML::script('assets/js/bootstrap-wysiwyg.min.js'); }}
<script>
    $(document).ready(function(){
        function showErrorAlert (reason, detail) {
            var msg='';
            if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
            else {
                //console.log("error uploading file", reason, detail);
            }
            $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
        }
        $('#editor1').ace_wysiwyg({
            toolbar:
                [
                    'font',
                    null,
                    'fontSize',
                    null,
                    {name:'bold', className:'btn-info'},
                    {name:'italic', className:'btn-info'},
                    {name:'strikethrough', className:'btn-info'},
                    {name:'underline', className:'btn-info'},
                    null,
                    {name:'insertunorderedlist', className:'btn-success'},
                    {name:'insertorderedlist', className:'btn-success'},
                    {name:'outdent', className:'btn-purple'},
                    {name:'indent', className:'btn-purple'},
                    null,
                    {name:'justifyleft', className:'btn-primary'},
                    {name:'justifycenter', className:'btn-primary'},
                    {name:'justifyright', className:'btn-primary'},
                    {name:'justifyfull', className:'btn-inverse'},
                    null,
                    {name:'createLink', className:'btn-pink'},
                    {name:'unlink', className:'btn-pink'},
                    null,
                    {name:'insertImage', className:'btn-success'},
                    null,
                    'foreColor',
                    null,
                    {name:'undo', className:'btn-grey'},
                    {name:'redo', className:'btn-grey'}
                ],
            'wysiwyg': {
                fileUploadError: showErrorAlert
            }
        }).prev().addClass('wysiwyg-style2');
        if ( typeof jQuery.ui !== 'undefined' && ace.vars['webkit'] ) {

            var lastResizableImg = null;
            function destroyResizable() {
                if(lastResizableImg == null) return;
                lastResizableImg.resizable( "destroy" );
                lastResizableImg.removeData('resizable');
                lastResizableImg = null;
            }

            var enableImageResize = function() {
                $('.wysiwyg-editor')
                    .on('mousedown', function(e) {
                        var target = $(e.target);
                        if( e.target instanceof HTMLImageElement ) {
                            if( !target.data('resizable') ) {
                                target.resizable({
                                    aspectRatio: e.target.width / e.target.height,
                                });
                                target.data('resizable', true);

                                if( lastResizableImg != null ) {
                                    //disable previous resizable image
                                    lastResizableImg.resizable( "destroy" );
                                    lastResizableImg.removeData('resizable');
                                }
                                lastResizableImg = target;
                            }
                        }
                    })
                    .on('click', function(e) {
                        if( lastResizableImg != null && !(e.target instanceof HTMLImageElement) ) {
                            destroyResizable();
                        }
                    })
                    .on('keydown', function() {
                        destroyResizable();
                    });
            }

            enableImageResize();

            /**
             //or we can load the jQuery UI dynamically only if needed
             if (typeof jQuery.ui !== 'undefined') enableImageResize();
             else {//load jQuery UI if not loaded
			//in Ace demo dist will be replaced by correct assets path
			$.getScript("assets/js/jquery-ui.custom.min.js", function(data, textStatus, jqxhr) {
				enableImageResize()
			});
		}
             */
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                console.log(input.files);
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.news_image_preview').show();
                    $('.news_image_preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#news_image").change(function () {
            $(".news_image_old").hide();
            var fileSize = this.files[0].size;
            var fileType = this.files[0].type;
            if(fileSize>1048576*2){ //do something if file size more than 1 mb (1048576)
                bootbox.alert('Kích thước file ảnh quá lớn');
                $(".news_image_remove").trigger('click');
                return false;
            }else{
                switch(fileType){
                    case 'image/png':
                    //case 'image/gif':
                    case 'image/jpeg':
                    case 'image/pjpeg':
                        break;
                    default:
                        bootbox.alert('File ảnh không đúng định dạng');
                        $(".news_image_remove").trigger('click');
                        $(".news_image_old").show();
                        return false;
                }
            }
            readURL(this);
        });

        $(".news_image_remove").on('click', function () {
            var $el = $('#news_image');
            $el.wrap('<form>').closest('form').get(0).reset();
            $el.unwrap();
            $('.news_image_preview').hide();
        });

        $(".sys_save_news").on('click',function(){
            $("#news_content").val($("#editor1").html());
            $('form').submit();
        });
    })
</script>
