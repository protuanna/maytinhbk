<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách tài khoản</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        {{--<div class="page-header">--}}
        {{--<h1>--}}
        {{--<small>--}}
        {{--Danh sách khách hàng--}}
        {{--</small>--}}
        {{--</h1>--}}
        {{--</div><!-- /.page-header -->--}}

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-lg-3">
                            <label for="user_name"><i>Tên đăng nhập</i></label>
                            <input type="text" class="form-control input-sm" id="user_name" name="user_name" autocomplete="off" placeholder="Tên đăng nhập" @if(isset($dataSearch['user_name']))value="{{$dataSearch['user_name']}}"@endif>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.user_create')}}">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Thêm mới
                            </a>
                        </span>
                        <span class="">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
                        </span>
                    </div>
                    {{ Form::close() }}
                </div>
                @if(sizeof($data) > 0)
                    <div class="span clearfix"> @if($size >0) Có tổng số <b>{{$size}}</b> tài khoản  @endif </div>
                    <br>
                    <table class="table table-bordered">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="15%" class="text-center">STT</th>
                            <th width="40%">Thông tin</th>
                            <th width="15%" class="text-center">Ngày tạo</th>
                            <th width="20%" class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr @if($item['user_status'] == -1)class="red bg-danger" @endif>
                                <td class="text-center">{{ $start+$key+1 }}</td>
                                <td>
                                    <div class="green"><b>Tài khoản : </b>{{ $item['user_name'] }}</div>
                                    <div><b>Tên : </b>{{ $item['user_full_name'] }}</div>
                                </td>
                                <td class="text-center">
                                    @if($item['user_created'])
                                        {{ date("d-m-Y",$item['user_created']) }}
                                    @endif
                                </td>
                                <td class="text-center" align="center">
                                    <br/>
                                    @if($user['user_name'] == 'admin')
                                        <a href="{{URL::route('admin.user_edit',array('id' => $item['user_id']))}}" class="btn btn-xs btn-primary" data-content="Sửa thông tin tài khoản" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-edit bigger-120"></i>
                                        </a>
                                    @endif
                                    @if($user['user_name'] == 'admin')
                                        <a href="{{URL::route('admin.user_change',array('id' => base64_encode($item['user_id'])))}}" class="btn btn-xs btn-success" data-content="Đổi mật khẩu" data-placement="bottom" data-trigger="hover" data-rel="popover">
                                            <i class="ace-icon fa fa-unlock bigger-120"></i>
                                        </a>
                                    @endif
                                    @if($user['user_name'] == 'admin')
                                        <a href="javascript:void(0)" class="btn btn-xs btn-danger sys_delete_user" data-content="Xóa tài khoản" data-placement="bottom" data-trigger="hover" data-rel="popover" data-id="{{$item['user_id']}}">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{$paging}}
                    </div>
                @else
                    <div class="alert">
                        Không có dữ liệu
                    </div>
                @endif
                            <!-- PAGE CONTENT ENDS -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.page-content -->
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('[data-rel=popover]').popover({container: 'body'});
        $(".sys_delete_user").on('click',function(){
            var $this = $(this);
            var id = $(this).attr('data-id');
            bootbox.confirm("Bạn chắc chắn muốn xóa tài khoản này", function(result) {
                if(result == true){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: WEB_ROOT + '/admin/user/remove/'+id,
                        data: {
                        },
                        beforeSend: function () {
                            $('.modal').modal('hide')
                        },
                        error: function () {
                            bootbox.alert('Lỗi hệ thống');
                        },
                        success: function (data) {
                            if(data.success == 1){
                                bootbox.alert('Xóa tài khoản thành công');
                                $this.parents('tr').html('');
                            }else{
                                bootbox.alert('Lỗi cập nhật');
                            }
                        }
                    });
                }
            });
        });
    })

</script>