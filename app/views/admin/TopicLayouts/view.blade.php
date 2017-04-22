<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách chuyên mục mục</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="col-sm-12 text-right">
                    <span class="">
                        <a class="btn btn-danger btn-sm" href="{{URL::route('admin.topic_edit')}}">
                            <i class="ace-icon fa fa-plus-circle"></i>
                            Thêm mới
                        </a>
                    </span>
                </div>
                @if(sizeof($data) > 0)
                    <table class="table table-bordered table-hover dataTable">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="10%" class="text-center">STT</th>
                            <th width="10%" class="text-center">ID</th>
                            <th width="25%">Chuyên mục</th>
                            <th width="15%" class="text-right">Trạng thái</th>
                            <th width="10%" class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>{{ $item['topic_id'] }}</td>
                                <td class="text-left">{{ $item['topic_title'] }}</td>
                                <td class="text-center">{{$aryStatus[$item['topic_status']]}}</td>
                                <td class="text-center">
                                    <a href="{{URL::route('admin.topic_edit',array('id' => $item['topic_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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


