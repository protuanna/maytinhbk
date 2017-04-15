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

    public function __construct()
    {
        if (!User::isLogin()) {

            Redirect::route('admin.login',array('url'=>self::buildUrlEncode(URL::current())))->send();
        }

        $this->user = User::user_login();
        View::share('user',$this->user);

    }

}