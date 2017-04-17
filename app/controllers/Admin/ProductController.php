<?php

/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 30/05/2015
 * Time: 8:20 CH
 */
class ProductController extends BaseAdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $pageNo = (int)Request::get('page_no', 1);
        $limit = 30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;
        $search['product_name'] = Request::get('product_name', '');
        $search['product_code'] = Request::get('product_code', '');
        $search['product_id'] = Request::get('product_id', '');
        $param = $search;
        $param['product_id'] = ($param['product_id'] != '') ? explode(',',$param['product_id']) : array();
        $param['product_code'] = ($param['product_code'] != '') ? explode(',',$param['product_code']) : array();
        $dataSearch = Product::searchByCondition($param, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
        $this->layout->content = View::make('admin.ProductLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo - 1) * $limit)
            ->with('total', $total)
            ->with('data', $dataSearch)
            ->with('search', $search);
    }

    public function getCreate($id = 0)
    {
        $data = array();
        if ($id > 0) {
            $data = Product::find($id);
        }
        $this->layout->content = View::make('admin.ProductLayouts.add')
            ->with('id', $id)
            ->with('data', $data);
    }

    public function postCreate($id = 0)
    {

        $dataSave['product_name'] = Request::get('product_name');
        $dataSave['product_code'] = Request::get('product_code');
        $product_price = Request::get('product_price');
        $dataSave['product_price'] =  (int)str_replace('.','',$product_price);
        $dataSave['product_status'] = (int)Request::get('product_status');
        $dataSave['product_content'] = htmlspecialchars(trim(Request::get('product_content')));
        $dataSave['product_tech'] = htmlspecialchars(trim(Request::get('product_tech')));
        $file = $files = null;
        if ( Input::hasFile('product_avatar')) {
            $file = Input::file('product_avatar');
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            if(!in_array($extension,FunctionLib::$array_allow_image) || $size > FunctionLib::$size_image_max){
                $error[] = 'Ảnh đại diện không hợp lệ';
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
            $error[] = 'Ảnh sản phẩm không hợp lệ';
        }
        if ($this->valid($dataSave, $id) && empty($this->error)) {
            if ($file) {
                $name = time() . '-av-' . $file->getClientOriginalName();
                $file->move(Constant::dir_product, $name);
                $dataSave['product_avatar'] = $name;
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
                    return Redirect::route('admin.product_list');
                }
            } else {
                if (Product::add($dataSave)) {
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

}