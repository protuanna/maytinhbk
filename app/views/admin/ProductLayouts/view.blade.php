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
                        <div class="form-group col-sm-4">
                            <label for="product_id"><i>ID sản phẩm</i></label>
                            <input type="text" class="form-control input-sm" id="product_id" name="product_id"  placeholder="id sản phẩm" @if(isset($search['product_id']) && $search['product_id'] != '')value="{{$search['product_id']}}"@endif>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="product_id"><i>Mã sản phẩm</i></label>
                            <input type="text" class="form-control input-sm" id="product_code" name="product_code"  placeholder="mã sản phẩm" @if(isset($search['product_code']) && $search['product_code'] != '')value="{{$search['product_code']}}"@endif>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="product_name"><i>Tên sản phẩm</i></label>
                            <input type="text" class="form-control input-sm" id="product_name" name="product_name"  placeholder="Tên sản phẩm" @if(isset($search['product_name']) && $search['product_name'] != '')value="{{$search['product_name']}}"@endif>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="category_id"><i>Danh mục</i></label>
                            <select name="category_id" id="category_id" class="form-control input-sm">
                                <option value="0" @if(isset($search['category_id']) && $search['category_id'] == 0) selected="selected" @endif>Danh mục</option>
                                {{$option}}
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="product_status"><i>Hiển thị trên site</i></label>
                            <select name="product_status" id="product_status" class="form-control input-sm">
                                <option value="-1" @if(isset($search['product_status']) && $search['product_status'] == -1) selected="selected" @endif>Tất cả</option>
                                <option value="1" @if(isset($search['product_status']) && $search['product_status'] == 1) selected="selected" @endif>Hiển thị</option>
                                <option value="0" @if(isset($search['product_status']) && $search['product_status'] == 0) selected="selected" @endif>Không</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="product_home"><i>Hiển thị trang chủ</i></label>
                            <select name="product_home" id="product_home" class="form-control input-sm">
                                <option value="-1" @if(isset($search['product_home']) && $search['product_home'] == -1) selected="selected" @endif>Tất cả</option>
                                <option value="1" @if(isset($search['product_home']) && $search['product_home'] == 1) selected="selected" @endif>Hiển thị</option>
                                <option value="0" @if(isset($search['product_home']) && $search['product_home'] == 0) selected="selected" @endif>Không</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.product_edit')}}">
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
                    <div class="span clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> sản phẩm @endif </div>
                    <br>
                    <table class="table table-bordered table-hover dataTable">
                        <thead class="thin-border-bottom">
                        <tr class="">
                            <th width="5%" class="text-center">STT</th>
                            <th width="5%" class="text-center">ID</th>
                            <th width="50%">Sản phẩm</th>
                            <th width="20%">Danh mục</th>
                            <th width="10%" class="text-right">Giá</th>
                            <th width="10%" class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td>{{ $item['product_id'] }}</td>
                                <td>{{ $item['product_name'] }}</td>
                                <td>{{ $category[$item['category_id']] }}</td>
                                <td class="text-right">{{number_format($item['product_price'],0,'.','.')}} đ</td>
                                <td class="text-center">
                                    <a href="{{URL::route('admin.product_edit',array('id' => $item['product_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
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


