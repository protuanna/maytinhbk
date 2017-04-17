<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.product_list')}}"> Danh sách sản phẩm</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin sản phẩm @else Tạo mới thông tin sản phẩm @endif</li>
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
                <div class="form-group col-sm-6">
                    <label for="product_name"><i>Tên sản phẩm</i><span style="color: red"> *</span></label>
                    <input type="text" placeholder="Tên sản phẩm" id="product_name" name="product_name"
                           class="form-control input-sm"
                           value="@if(isset($data['product_name'])){{$data['product_name']}}@endif">
                </div>
                <div class="form-group col-sm-3">
                    <label for="product_price"><i>Giá</i></label>
                    <input align="right" style="text-align: right" type="text" class="form-control input-sm" id="product_price" name="product_price" value="@if(isset($data['product_price'])){{number_format($data['product_price'],0,'.','.')}}@endif">
                </div>
                <div class="form-group col-sm-3">
                    <label for="product_status"><i>Hiển thị trên site</i></label>
                    <select name="product_status" id="product_status" class="form-control input-sm">
                        <option value="0" @if(isset($data['product_status']) && $data['product_status'] == 0) selected="selected" @endif>Ẩn</option>
                        <option value="1" @if(isset($data['product_status']) && $data['product_status'] == 1) selected="selected" @endif>Hiện</option>
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label>Ảnh đại diện</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="product_avatar" name="product_avatar" accept="image/*">
                        <span data-title="Chọn ảnh đại diện" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 156px;height: 190px;padding: 2px;border: 1px solid gainsboro;display: none" class="product_avatar_preview">
                        <img src="" alt="" width="150" height="150">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 product_avatar_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i> Hủy
                            </button>
                        </div>
                    </div>
                    @if(isset($data['product_avatar']) && $data['product_avatar'] != '')
                        <div style="width: 156px;height: 156px;padding: 2px;border: 1px solid gainsboro" class="product_avatar_old">
                            <img src="{{Croppa::url(Constant::dir_product.$data['product_avatar'], 150, 150)}}" alt="" width="150" height="150">
                        </div>
                    @endif
                </div>

                <div class="form-group col-sm-3">
                    <label>Ảnh hover</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="product_avatar_hover" name="product_avatar_hover" accept="image/*">
                        <span data-title="Chọn ảnh đại diện" class="ace-file-container"></span>
                    </label>
                    <div class="clearfix"></div>
                    <div style="width: 156px;height: 190px;padding: 2px;border: 1px solid gainsboro;display: none" class="product_avatar_hover_preview">
                        <img src="" alt="" width="150" height="150">
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-danger col-sm-12 product_avatar_hover_remove" type="button">
                                <i class="ace-icon fa fa-remove bigger-110"></i> Hủy
                            </button>
                        </div>
                    </div>
                    @if(isset($data['product_avatar_hover']) && $data['product_avatar_hover'] != '')
                        <div style="width: 156px;height: 156px;padding: 2px;border: 1px solid gainsboro" class="product_avatar_hover_old">
                            <img src="{{Croppa::url(Constant::dir_product.$data['product_avatar_hover'], 150, 150)}}" alt="" width="150" height="150">
                        </div>
                    @endif
                </div>

                <div class="form-group col-sm-6">
                    <label>Ảnh sản phẩm (Size <= 1mb. Ảnh : png,jpg,jpeg. Tỉ lệ 1:1)</label>
                    <div class="clearfix"></div>
                    <label class="ace-file-input">
                        <input type="file" id="product_image" name="product_image[]"  accept="image/*" multiple>
                        <span data-title="Chọn ảnh sản phẩm" class="ace-file-container"></span>
                    </label>
                    <button class="btn btn-sm btn-danger product_image_remove pull-right" type="button" style="display: none">
                        <i class="ace-icon fa fa-remove bigger-110"></i> Hủy
                    </button>
                    <div class="clearfix"></div>
                    <div style="width: 100%;display: none;" class="product_image_preview">

                    </div>
                    @if(isset($data['product_image']) && $data['product_image'] != '')
                        <div style="width: 100%;" class="product_image_old">
                            <?php $aryImage = json_decode($data['product_image'],true);?>
                            @foreach($aryImage as $image)
                                    <div style="width: 156px;height: 156px;padding: 2px;margin: 2px;border: 1px solid gainsboro;float: left"><img src="{{Croppa::url(Constant::dir_product.$image, 150, 150)}}" alt="" width="150" height="150"></div>
                            @endforeach
                        </div>
                        {{--<div style="width: 41px;height: 41px;padding: 2px;border: 1px solid gainsboro" class="product_avatar_old">
                            <img src="{{Croppa::url(Constant::dir_product.$param['product_Avatar'], 35, 35)}}" alt="" width="35" height="35">
                        </div>--}}
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <div class="wysiwyg-editor" id="editor1">
                        @if(isset($data['product_content']))
                            {{htmlspecialchars_decode($data['product_content'])}}
                        @endif
                    </div>
                    <input type="hidden" id="product_content" name="product_content" @if(isset($data['product_content'])) value="" @endif>
                </div>
                <!-- PAGE CONTENT ENDS -->
                <div class="clearfix space-6"></div>
                <div class="form-group col-sm-12 text-right" style="margin-top: 30px">
                    <button  class="btn btn-primary sys_save_product"><i class="glyphicon glyphicon-floppy-saved"></i> Lưu lại</button>
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
    $("#product_price").on('keyup', function (event) {
        product.fomatNumber('product_price');
    });
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

        $(".sys_save_product").on('click',function(){
            $("#product_content").val($("#editor1").html());
            $('form').submit();
        });
    })
</script>
{{HTML::script('assets/admin/js/product.js');}}