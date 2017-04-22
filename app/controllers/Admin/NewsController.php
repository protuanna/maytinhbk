<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 4/22/2017
 * Time: 9:27 AM
 */
class NewsController extends BaseAdminController
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
        $search['news_title'] = Request::get('news_title', '');
        $search['topic_id'] = (int)Request::get('topic_id', 0);
        $search['news_status'] = (int)Request::get('news_status', -1);
        $param = $search;
        $dataSearch = News::searchByCondition($param, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
        $topic = Topic::getListShow();
        $this->layout->content = View::make('admin.NewsLayouts.view')
            ->with('paging', $paging)
            ->with('stt', ($pageNo - 1) * $limit)
            ->with('topic', $topic)
            ->with('total', $total)
            ->with('data', $dataSearch)
            ->with('search', $search);
    }

    public function getCreate($id = 0)
    {
        $data = array();
        if ($id > 0) {
            $data = News::find($id);
        }
        $topic = Topic::getListShow();
        $this->layout->content = View::make('admin.NewsLayouts.add')
            ->with('id', $id)
            ->with('topic', $topic)
            ->with('data', $data);
    }

    public function postCreate($id = 0)
    {

        $dataSave['news_title'] = Request::get('news_title', '');
        $dataSave['news_status'] = (int)Request::get('product_status', 0);
        $dataSave['topic_id'] = (int)Request::get('category_id', 0);
        $dataSave['news_content'] = htmlspecialchars(trim(Request::get('product_content', '')));
        $error = array();
        if($dataSave['news_title'] == ''){
            $error[] = 'Chưa nhập tiêu đề bài viết';
        }
        if($dataSave['topic_id'] == 0){
            $error[] = 'Chưa chọn chủ đề';
        }
        $file = $files = null;
        if ( Input::hasFile('news_image')) {
            $file = Input::file('news_image');
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            if(!in_array($extension,FunctionLib::$array_allow_image) || $size > FunctionLib::$size_image_max){
                $error[] = 'Ảnh đại diện không hợp lệ';
            }
        }
        if (!$error) {
            if ($file) {
                $name = time() . '-ns-' . $file->getClientOriginalName();
                $file->move(Constant::dir_news, $name);
                $dataSave['news_image'] = $name;
            }
            if ($id > 0) {
                if (Product::updData($id, $dataSave)) {
                    return Redirect::route('admin.news_list');
                }
            } else {
                $dataSave['news_created'] = time();
                $dataSave['user_id'] = $this->user['user_id'];
                if (Product::add($dataSave)) {
                    return Redirect::route('admin.news_list');
                }
            }
        }
        if ($id > 0) {
            $pro = News::find($id);
            $dataSave['news_image'] = $pro['news_image'];
        }
        $topic = Topic::getListShow();
        $this->layout->content = View::make('admin.NewsLayouts.add')
            ->with('id', $id)
            ->with('topic', $topic)
            ->with('data', $dataSave)
            ->with('error', $error);
    }
}