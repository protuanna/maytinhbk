<?php

/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 29/05/2015
 * Time: 6:33 SA
 */
class UserController extends BaseAdminController
{

    private $arrStatus = array(0 => 'Tất cả', 1 => 'Hoạt động', -1 => "Khóa");

    public function __construct()
    {
        parent::__construct();
    }

    public function view()
    {
        $this->layout->title = "Quản trị tài khoản";
        $page_no = Request::get('page_no', 1);
        $dataSearch['user_status'] = Request::get('user_status', 0);
        $dataSearch['user_email'] = Request::get('user_email', '');
        $dataSearch['user_full_name'] = Request::get('user_full_name', '');
        $dataSearch['user_name'] = Request::get('user_name', '');
        $limit = 30;
        $size = 0;
        $offset = ($page_no - 1) * $limit;
        $data = User::searchByCondition($dataSearch, $limit, $offset, $size);
        $paging = $size > 0 ? Pagging::getNewPager(3,$page_no,$size,$limit,$dataSearch) : '';
        $this->layout->content = View::make('admin.UserLayouts.view')
            ->with('arrStatus', $this->arrStatus)
            ->with('data', $data)
            ->with('dataSearch', $dataSearch)
            ->with('size', $size)
            ->with('start', ($page_no - 1) * $limit)
            ->with('paging', $paging);
    }

    public function createInfo()
    {
        if($this->user['user_name'] !== 'admin'){
            return Redirect::route('admin.dashboard');
        }
        $this->layout->content = View::make('admin.UserLayouts.create');
    }

    public function create()
    {

        if($this->user['user_name'] !== 'admin'){
            return Redirect::route('admin.dashboard');
        }
        $error = array();
        $data['user_name'] = htmlspecialchars(trim(Request::get('user_name', '')));
        $data['user_full_name'] = htmlspecialchars(trim(Request::get('user_full_name', '')));

        if ($data['user_name'] == '') {
            $error[] = 'Tên đăng nhập không được bỏ trống';
        } else {
            $dataResponse = User::getUserByName($data['user_name']);
            if ($dataResponse) {
                $error[] = 'Tên đăng nhập đã tồn tại!';
            }
        }

        if (isset($data['user_full_name']) && $data['user_full_name'] == '') {
            $error[] = 'Tên không được bỏ trống';
        }

        if ($error) {
            $this->layout->content = View::make('admin.UserLayouts.create')
                ->with('error', $error)
                ->with('data', $data);
        } else {
            //Insert dữ liệu
            $dataInsert['user_name'] = $data['user_name'];
            $dataInsert['user_full_name'] = $data['user_full_name'];
            $dataInsert['user_status'] = 1;
            $dataInsert['user_password'] = 'abc@123';
            $dataInsert['user_create_id'] = User::user_id();
            $dataInsert['user_create_name'] = User::user_name();
            $dataInsert['user_created'] = time();


            if (User::createNew($dataInsert)) {
                return Redirect::route('admin.user_view');
            } else {
                $error['mess'] = 'Lỗi truy xuất dữ liệu';
                $this->layout->content = View::make('admin.UserLayouts.create')
                    ->with('error', $error)
                    ->with('data', $data);
            }
        }
    }

    public function changePassInfo($ids)
    {
        $id = base64_decode($ids);
        if ((int)$id !== (int)$this->user['user_id'] && $this->user['user_name'] !== 'admin') {
            return Redirect::route('admin.dashboard');
        }

        $this->layout->content = View::make('admin.UserLayouts.change')
            ->with('id', $id);
    }

    public function changePass($ids)
    {
        $id = base64_decode($ids);
        if ((int)$id !== (int)$this->user['user_id'] && $this->user['user_name'] !== 'admin') {
            return Redirect::route('admin.dashboard');
        }

        $error = array();
        $old_password = Request::get('old_password', '');
        $new_password = Request::get('new_password', '');
        $confirm_new_password = Request::get('confirm_new_password', '');
        if($this->user['user_name'] !== 'admin'){
            $user_byId = User::getUserById($id);
            if($old_password == ''){
                $error[] = 'Bạn chưa nhập mật khẩu hiện tại';
            }
            if(User::encode_password($old_password) !== $user_byId->user_password ){
                $error[] = 'Mật khẩu hiện tại không chính xác';
            }
        }
        if ($new_password == '') {
            $error[] = 'Bạn chưa nhập mật khẩu mới';
        } elseif (strlen($new_password) < 5) {
            $error[] = 'Mật khẩu quá ngắn';
        }
        if ($confirm_new_password == '') {
            $error[] = 'Bạn chưa xác nhận mật khẩu mới';
        }
        if ($new_password != '' && $confirm_new_password != '' && $confirm_new_password !== $new_password) {
            $error[] = 'Mật khẩu xác nhận không chính xác';
        }
        if ($error) {
            $this->layout->content = View::make('admin.UserLayouts.change')->with('id', $id)
                ->with('error', $error);
        } else {
            //Insert dữ liệu
            if (User::updatePassword($id, $new_password)) {
                if((int)$id === (int)$this->user['user_id']){
                    return Redirect::route('admin.dashboard');
                }else{
                    return Redirect::route('admin.user_view');
                }
            } else {
                $error[] = 'Không update được dữ liệu';
                $this->layout->content = View::make('admin.UserLayouts.change')->with('id', $id)
                    ->with('error', $error);
            }
        }
    }

    public function editInfo($id)
    {
        if($this->user['user_name'] !== 'admin'){
            return Redirect::route('admin.dashboard');
        }
        $data = User::getUserById($id);
        $this->layout->content = View::make('admin.UserLayouts.edit')
            ->with('arrStatus', $this->arrStatus)
            ->with('data', $data);
    }

    public function edit($id)
    {
        if($this->user['user_name'] !== 'admin'){
            return Redirect::route('admin.dashboard');
        }
        $error = array();
        $data['user_id'] = $id;
        $data['user_status'] = (int)Request::get('user_status', -1);
        $data['user_full_name'] = htmlspecialchars(trim(Request::get('user_full_name', '')));


        if (isset($data['user_full_name']) && $data['user_full_name'] == '') {
            $error[] = 'Tên không được bỏ trống';
        }

        $data['user_name'] = Request::get('user_name', '');
        if ($error) {
            $this->layout->content = View::make('admin.UserLayouts.edit')
                ->with('error', $error)
                ->with('data', $data)
                ->with('arrStatus', $this->arrStatus);
        } else {
            //Insert dữ liệu
            $dataInsert['user_full_name'] = $data['user_full_name'];
            $dataInsert['user_status'] = (int)$data['user_status'];
            $dataInsert['user_edit_id'] = User::user_id();
            $dataInsert['user_edit_name'] = User::user_name();
            $dataInsert['user_updated'] = time();
            if (User::updateUser($id, $dataInsert)) {
                return Redirect::route('admin.user_view');
            } else {
                $error[] = 'Lỗi truy xuất dữ liệu';;
                $this->layout->content = View::make('admin.UserLayouts.edit')
                    ->with('error', $error)
                    ->with('data', $data)
                    ->with('arrStatus', $this->arrStatus);
            }
        }

    }

    public function remove($id){
        $data['success'] = 0;
/*        if(!in_array($this->permission_remove, $this->permission)){
            return Response::json($data);
        }*/
        $user = User::find($id);
        if($user){
            if(User::remove($user)){
                $data['success'] = 1;
            }
        }
        return Response::json($data);
    }


}