<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li><a href="{{URL::route('admin.topic_list')}}"> Danh sách chuyên mục</a></li>
            <li class="active">@if($id > 0)Cập nhật thông tin chuyên mục @else Tạo mới thông tin chuyên mục @endif</li>
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
                <div class="form-group col-sm-3">
                    <label for="topic_title"><i>Tên chuyên mục</i><span style="color: red"> *</span></label>
                    <input type="text" placeholder="Tên chuyên mục" id="topic_title" name="topic_title"
                           class="form-control input-sm"
                           value="@if(isset($data['topic_title'])){{$data['topic_title']}}@endif">
                </div>
                <div class="form-group col-sm-3">
                    <label for="topic_status"><i>Hiển thị</i></label>
                    <select name="topic_status" id="topic_status" class="form-control input-sm">
                        <option value="1" @if(isset($data['topic_status']) && $data['topic_status'] == 1) selected="selected" @endif>Hiện</option>
                        <option value="0" @if(isset($data['topic_status']) && $data['topic_status'] == 0) selected="selected" @endif>Ẩn</option>
                    </select>
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
<script>
</script>