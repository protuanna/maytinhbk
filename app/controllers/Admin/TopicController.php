<?php

/**
 * Created by PhpStorm.
 * User: PC0353
 * Date: 4/17/2017
 * Time: 2:30 PM
 */
class TopicController extends BaseAdminController
{

    private $aryStatus = array(-1 => 'Tất cả', 1 => 'Hiển thị', 0 => "Ẩn");

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $topic = Topic::getListAll();
        $this->layout->content = View::make('admin.TopicLayouts.view')
            ->with('aryStatus', $this->aryStatus)
            ->with('topic', $topic);
    }

    public function getCreate($id = 0)
    {
        $data = array();
        if ($id > 0) {
            $data = Topic::find($id);
        }
        $this->layout->content = View::make('admin.TopicLayouts.add')
            ->with('id', $id)
            ->with('data', $data);
    }

    public function postCreate($id = 0)
    {
        $error = array();
        $dataSave['topic_name'] = Request::get('topic_name', '');
        $dataSave['topic_status'] = (int)Request::get('topic_status', 0);
        if($dataSave['topic_name'] == ''){
            $error[] = 'Chưa nhập tên chuyên mục';
        }
        if(!$error){
            if ($id > 0) {
                if (Topic::updData($id, $dataSave)) {
                    return Redirect::route('admin.topic_list');
                }
            } else {
                if (Topic::add($dataSave)) {
                    return Redirect::route('admin.topic_list');
                }
            }
        }
        $this->layout->content = View::make('admin.TopicLayouts.add')
            ->with('id', $id)
            ->with('data', $dataSave)
            ->with('error', $error);
    }
}