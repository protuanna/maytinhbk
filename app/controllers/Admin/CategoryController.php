<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 4/17/2017
 * Time: 2:30 PM
 */
class CategoryController extends BaseAdminController
{

    private $aryStatus = array(-1 => 'Tất cả', 1 => 'Hiển thị', 0 => "Ẩn");

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $search = $data = array();
        $total = 0;
        $search['category_name'] = Request::get('category_name', '');
        $search['category_id'] = Request::get('category_id', '');
        $search['category_status'] = (int)Request::get('category_status', -1);
        $param = $search;
        $param['category_id'] = ($param['category_id'] != '') ? explode(',',$param['category_id']) : array();
        $dataSearch = Category::searchByCondition($param,$total);
        $category = Category::getListAll();
        $this->layout->content = View::make('admin.CategoryLayouts.view')
            ->with('total', $total)
            ->with('aryStatus', $this->aryStatus)
            ->with('category', $category)
            ->with('data', $dataSearch)
            ->with('search', $search);
    }

    public function getCreate($id = 0)
    {
        $data = array();
        if ($id > 0) {
            $data = Category::find($id);
        }
        $active_id = $data ? $data['category_parent_id'] : 0;
        $option = $this->navCategory($active_id);
        $this->layout->content = View::make('admin.CategoryLayouts.add')
            ->with('id', $id)
            ->with('option', $option)
            ->with('data', $data);
    }

    public function postCreate($id = 0)
    {
        $error = array();
        $dataSave['category_name'] = Request::get('category_name', '');
        $dataSave['category_parent_id'] = (int)Request::get('category_parent_id', 0);
        $dataSave['category_status'] = (int)Request::get('category_status', 0);
        if($dataSave['category_name'] == ''){
            $error[] = 'Chưa nhập tên danh mục';
        }
        if(!$error){
            if ($id > 0) {
                if (Category::updData($id, $dataSave)) {
                    return Redirect::route('admin.category_list');
                }
            } else {
                if (Category::add($dataSave)) {
                    return Redirect::route('admin.category_list');
                }
            }
        }
        $option = $this->navCategory($id);
        $this->layout->content = View::make('admin.CategoryLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('option', $option)
            ->with('error', $error);
    }
}