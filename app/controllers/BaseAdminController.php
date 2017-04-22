<?php
/**
 * Created by PhpStorm.
 * User: Tuan
 * Date: 29/05/2015
 * Time: 8:27 CH
 */
class BaseAdminController extends BaseController
{

    protected $layout = 'admin.AdminLayouts.index';
    protected $user = array();

    private $category = array();
    private $html = '';

    public function __construct()
    {
        if (!User::isLogin()) {

            Redirect::route('admin.login',array('url'=>self::buildUrlEncode(URL::current())))->send();
        }

        $this->user = User::user_login();
        View::share('user',$this->user);

    }

    public function navCategory($active_id){
        $category = Category::getAllShow()->toArray();
        if(sizeof($category) > 0){
            $this->category = $category;
            $this->buildOption($active_id,0,'');
        }
        return $this->html;
    }

    public function getAllChild($parent_id){
        $category = Category::getAllShow()->toArray();
        $child = ($parent_id) ? array($parent_id) : null;
        if(sizeof($category) > 0){
            $this->category = $category;
            $this->getChild($parent_id,$child);
        }
        return $child;
    }

    private function buildOption($active_id,$parent_id,$i){
        foreach ($this->category as $k => $v){
            if($v['category_parent_id'] == $parent_id){
                if($active_id == $v['category_id']){
                    $this->html .= '<option value="' . $v['category_id'] . '" selected="selected">'.$i.$v['category_name'].'</option>';
                }else{
                    $this->html .= '<option value="' . $v['category_id'] . '">'.$i.$v['category_name'].'</option>';
                }
                if($this->hasChild($v['category_id'])){
                    $this->buildOption($active_id, $v['category_id'],$i.'-- ');
                }
            }
        }
    }

    private function getChild($parent_id, &$child)
    {
        foreach ($this->category as $k => $v) {
            if ($v['category_parent_id'] == $parent_id) {
                $child[] = $v['category_id'];
                if ($this->hasChild($v['category_id'])) {
                    $this->getChild($v['category_id'], $child);
                }
            }
        }
    }

    private function hasChild($parent_id){
        foreach ($this->category as $k => $v){
            if($v['category_parent_id'] == $parent_id){
                return true;
            }
        }
        return false;
    }

}