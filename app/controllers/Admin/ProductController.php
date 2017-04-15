<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class ProductController extends BaseAdminController
{
    private $permission_view = 'product_view';
    private $permission_delete = 'product_delete';
    private $permission_create = 'product_create';
    private $permission_edit = 'product_edit';


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //Check phan quyen.
/*        if(!in_array($this->permission_view,$this->permission)){
            return Redirect::route('admin.dashboard');
        }*/
        $pageNo = (int)Request::get('page_no', 1);
        $limit = 30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;
        $search['product_name'] = Request::get('product_Name', '');
        $search['product_id'] = Request::get('product_id', '');
        $param = $search;
        $param['product_id'] = ($param['product_id'] != '') ? explode(',',$param['product_id']) : array();
        $dataSearch = Product::searchByCondition($param, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
        $this->layout->content = View::make('admin.ProductLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo - 1) * $limit)
            ->with('total', $total)
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('permission_delete', 1)
            ->with('permission_create', 1)
            ->with('permission_edit', 1);
    }

    public function getCreate($id = 0)
    {

        $data = array();
        if ($id > 0) {
            $data = Product::find($id);
        }
        //echo '<pre>';  print_r($user); echo '</pre>'; die;
        $this->layout->content = View::make('admin.ProductLayouts.add')
            ->with('id', $id)
            ->with('data', $data);
    }

    public function postCreate($id = 0)
    {

        $dataSave['product_name'] = Request::get('product_name');
        $product_price = Request::get('product_price');
        $dataSave['product_price'] =  (int)str_replace('.','',$product_price);
        $dataSave['product_content'] = htmlspecialchars(trim(Request::get('product_content')));
        $dataSave['product_status'] = (int)Request::get('product_status');
        $file_1 = $file_2 = $files = null;
        if ( Input::hasFile('product_avatar')) {
            $file_1 = Input::file('product_avatar');
            $extension = $file_1->getClientOriginalExtension();
            $size = $file_1->getSize();
            if(!in_array($extension,FunctionLib::$array_allow_image) || $size > FunctionLib::$size_image_max){
                $this->error[] = 'Ảnh đại diện không hợp lệ';
            }
        }
        if ( Input::hasFile('product_avatar_hover')) {
            $file_2 = Input::file('product_avatar_hover');
            $extension = $file_2->getClientOriginalExtension();
            $size = $file_2->getSize();
            if(!in_array($extension,FunctionLib::$array_allow_image) || $size > FunctionLib::$size_image_max){
                $this->error[] = 'Ảnh hover không hợp lệ';
            }
        }
        $error_image = 0;
        if ( Input::hasFile('product_image')) {
            $files = Input::file('product_image');
            foreach($files as $fi){
                $extension = $fi->getClientOriginalExtension();
                $size = $fi->getSize();
                if(!in_array($extension,FunctionLib::$array_allow_image) || $size > FunctionLib::$size_image_max){
                    $error_image = 1;
                }
            }
        }
        if($error_image == 1){
            $this->error[] = 'Ảnh sản phẩm không hợp lệ';
        }
        if ($this->valid($dataSave, $id) && empty($this->error)) {
            if ($file_1) {
                $name = time() . '-av-' . $file_1->getClientOriginalName();
                $file_1->move(Constant::dir_product, $name);
                $dataSave['product_avatar'] = $name;
            }
            if ($file_2) {
                $name = time() . '-hv-' . $file_2->getClientOriginalName();
                $file_2->move(Constant::dir_product, $name);
                $dataSave['product_avatar_hover'] = $name;
            }
            if ($files) {
                $image = array();
                foreach ($files as $fi) {
                    $name = time() . '-img-' . $fi->getClientOriginalName();
                    $fi->move(Constant::dir_product, $name);
                    $image[] = $name;
                }
                if ($image) {
                    $dataSave['product_image'] = json_encode($image);
                }
            }
            if ($id > 0) {
                if (Product::updData($id, $dataSave)) {
                    //$dataSave['product_CreatedTime'] = time();

                    return Redirect::route('admin.product_list');
                }
            } else {
                if (Product::add($dataSave)) {
                   // $dataSave['product_ModifiedTime'] = time();
                    return Redirect::route('admin.product_list');
                }
            }
        }
        if ($id > 0) {
            $pro = Product::find($id);
            $dataSave['product_image'] = $pro['product_image'];
            $dataSave['product_avatar'] = $pro['product_avatar'];
            $dataSave['product_avatar_hover'] = $pro['product_avatar_hover'];
        }
        $this->layout->content = View::make('admin.ProductLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $this->error);
    }

    public function deleteItem()
    {
        $data = array('isIntOk' => 0);
        if(!in_array($this->permission_delete,$this->permission)){
            return Response::json($data);
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && Product::delData($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    public function getCategoryProduct()
    {
        return Categories::getCategoriessAll();
    }

    private function valid($data = array(), $id = 0)
    {
        if (!empty($data)) {
            if (isset($data['product_Name']) && $data['product_Name'] == '') {
                $this->error[] = 'Tên sản phẩm không được trống';
            }

            if (isset($data['product_Code']) && $data['product_Code'] == '') {
                $this->error[] = 'Mã sản phẩm không được trống';
            } elseif (isset($data['product_Code']) && $data['product_Code'] != '') {
                $product_Code = Product::getProductsByProductCode($data['product_Code']);
                if (!empty($product_Code) && !isset($product_Code[$id])) {
                    $this->error[] = 'Mã sản phẩm này đã tồn tại, hãy nhập mã khác';
                }
            }
            return true;
        }
        return false;
    }

    function updatecConvernt(){
        die;
        $product = DB::table('product')->get();;
        foreach ($product as $k => $va) {
            DB::table('product')
                ->where('product_id', $va->product_id)
                ->update(['product_NameOrigin' => isset($this->arrXuatXu[$va->product_OriginID]) ? $this->arrXuatXu[$va->product_OriginID] : '',
                    'product_NameUnit' => isset($this->arrDonViTinh[$va->product_UnitID]) ? $this->arrDonViTinh[$va->product_UnitID] : '']);
        }
        die('xong');

        /*echo '<pre>';
        print_r($product_categories);
        echo '</pre>';
        die;*/
    }

    public function getProductByName(){
        $name = Request::get('product_name', '');
        $product = Product::getListByName($name);
        $data['success'] = 1;
        $data['product'] = $product;
        return Response::json($data);
    }

}