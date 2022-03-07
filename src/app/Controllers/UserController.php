<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace  Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\HTTP\Gards\Auth;

    class UserController extends BaseController{

        /**
         * Return the welcome view
         */
        static function show(){
            if(Auth::guest()) {
                return self::response()->redirect('/login');
            }
            return self::response()->view('App/account');
        }
    }
}