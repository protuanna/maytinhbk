<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{{URL::route('admin.dashboard')}}">Home</a>
            </li>
            <li class="active">Danh sách Sản phẩm</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="panel panel-info">
                    {{ Form::open(array('method' => 'GET', 'role'=>'form')) }}
                    <div class="panel-body">
                        <div class="form-group col-sm-3">
                            <label for="category_id"><i>ID danh mục</i></label>
                            <input type="text" class="form-control input-sm" id="category_id" name="category_id"  placeholder="id danh mục" @if(isset($search['category_id']) && $search['category_id'] != '')value="{{$search['category_id']}}"@endif>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="category_name"><i>Tên danh mục</i></label>
                            <input type="text" class="form-control input-sm" id="category_name" name="category_name"  placeholder="Tên danh mục" @if(isset($search['category_name']) && $search['category_name'] != '')value="{{$search['category_name']}}"@endif>
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="category_status"><i>Trạng thái</i></label>
                            <select name="category_status" id="category_status" class="form-control input-sm">
                                @foreach($aryStatus as $k => $v)
                                <option value="{{$k}}">{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.category_edit')}}">
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
                    <table class="table table-bordered table-hover dataTable">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="10%" class="text-center">STT</th>
                            <th width="10%" class="text-center">ID</th>
                            <th width="40%">Danh mục</th>
                            <th width="20%" class="text-right">Trạng thái</th>
                            <th width="20%" class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>{{ $item['category_id'] }}</td>
                                <td class="text-left">{{ $item['category_name'] }}</td>
                                <td class="text-center">{{$aryStatus[$item['category_status']]}} đ</td>
                                <td class="text-center">
                                    <a href="{{URL::route('admin.category_edit',array('id' => $item['category_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
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


