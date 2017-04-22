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
                            <label for="news_title"><i>Tiêu đề</i></label>
                            <input type="text" class="form-control input-sm" id="news_title" name="news_title"  placeholder="Tiêu đề" @if(isset($search['news_title']) && $search['news_title'] != '')value="{{$search['news_title']}}"@endif>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="topic_id"><i>Chuyên mục</i></label>
                            <select name="topic_id" id="topic_id" class="form-control input-sm">
                                <option value="0" @if(isset($search['topic_id']) && $search['topic_id'] == 0) selected="selected" @endif>Chuyên mục</option>
                                @foreach($topic as $k => $v)
                                    <option value="{{$v}}" @if(isset($search['topic_id']) && $search['topic_id'] == $k) selected="selected" @endif>{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="news_status"><i>Hiển thị trên site</i></label>
                            <select name="news_status" id="news_status" class="form-control input-sm">
                                <option value="-1" @if(isset($search['news_status']) && $search['news_status'] == -1) selected="selected" @endif>Tất cả</option>
                                <option value="1" @if(isset($search['news_status']) && $search['news_status'] == 1) selected="selected" @endif>Hiển thị</option>
                                <option value="0" @if(isset($search['news_status']) && $search['news_status'] == 0) selected="selected" @endif>Không</option>
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <span class="">
                            <a class="btn btn-danger btn-sm" href="{{URL::route('admin.news_edit')}}">
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
                            <th width="10%" class="text-center">STT</th>
                            <th width="10%" class="text-center">ID</th>
                            <th width="30%">Tiêu đề</th>
                            <th width="30%">Chuyên mục</th>
                            <th width="20%" class="text-center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="text-center">{{ $stt + $key+1 }}</td>
                                <td>{{ $item['news_id'] }}</td>
                                <td>{{ $item['news_title'] }}</td>
                                <td>{{ isset($topic[$item['topic_id']]) ? $topic[$item['topic_id']] : '--' }}</td>
                                <td class="text-center">
                                    <a href="{{URL::route('admin.news_edit',array('id' => $item['news_id']))}}" title="Sửa item"><i class="fa fa-edit"></i></a>
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


