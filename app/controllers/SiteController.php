<?php

class SiteController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

    protected $layout = 'Web.init';

    public function __construct()
    {

    }

    public function showWelcome()
    {
        return View::make('hello');
    }

    public function home()
    {
        //$products = Product::getProductHome();
        //$this->layout->content = View::make('Web.home')->with('products',$products);
    }
}
