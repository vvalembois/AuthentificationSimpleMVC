<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Helpers\Session;
use Modules\Authentifier\Helpers\Cookies;

class LoginModel extends UserModel
{
    public static function findBySession(){
        $user = LoginModel::findByUserID(Session::get('user_id'));
        if($user instanceof LoginModel) {
            if ($user->checkSessionId(Session::id())) {
                return $user;

            }
            $user->logout(false);
        }
        // We need to clean the login session because of an exception when an administrator delete a logged user
        self::loginSessionDestroy();
        return null;
    }

    public static function findByCookie(){
        $user_id = Cookies::getcookie('user_id');
        if(isset($user_id)) {
            $user = LoginModel::findByUserID($user_id);
            if ($user instanceof LoginModel) {
                $cookie_token = Cookies::getcookie('user_token');
                if($user->checkUserRememberMeToken($cookie_token))
                    return $user;
                else{
                    $user->logout();
                }
            }
        }
        return null;
    }


    /**
     * Check if the visitor is logged in, else if he can login with a cookie
     * @return bool return true if the visitor is logged in
     */
    public static function userIsLoggedIn()
    {
        if(LoginModel::findBySession() instanceof LoginModel) {
            return true;
        }
        else{
            $user = LoginModel::findByCookie();
            if($user instanceof LoginModel){
                $user->connection();
                return true;
            }
        }
        return false;
    }

    /**
     * @param bool|false $remember_cookie Set true if the user want us to remember him and accept cookies
     */
    public function connection($remember_cookie = false){
        // Session
        Session::regenerate();
        Session::set('user_id', $this->getUserId());
        Session::set('user_name', $this->getUserName());

        // Cookie
        $cookie_token = null;
        if($remember_cookie) {
            $expire = 7; // 7 days before expiration of cookies
            Cookies::set('user_id', $this->user_id, $expire);
            Cookies::set('user_name', $this->user_name, $expire);
            $cookie_token = sha1(uniqid(mt_rand(), true));
            Cookies::set('user_token', $cookie_token, $expire);
        }

        // Database
        $this->setSessionId(Session::id());
        $this->setUserFailedLogins(0);
        $this->setUserLastLoginTimestamp('time');
        if(isset($cookie_token))
            $this->setUserRememberMeToken($cookie_token);
        $this->save();
    }

    /**
     * This method permit to logout and clear the session and cookies
     * @param bool|true $remember_cookie Set this param false if you want to not destroy the cookie (for specific uses like multi device login currently not available)
     */
    public function logout($remember_cookie = true)
    {
        // Session
        self::loginSessionDestroy();

        // Cookie
        if ($remember_cookie){
            $this->loginCookiesDestroy();
        }
    }

    /**
     * Clean the login session
     */
    public static function loginSessionDestroy(){
        Session::destroy('user_id');
        Session::destroy('user_name');
        Session::regenerate();
    }

    /**
     * Clean the login cookies
     */
    public static function loginCookiesDestroy(){
        Cookies::destroy('user_id');
        Cookies::destroy('user_name');
        Cookies::destroy('user_token');
    }

    public function loginFailed(){
        $this->user_failed_logins ++;
        $this->setUserLastFailedLogin(time());
        $this->setUserLastFailedLoginIp($_SERVER['REMOTE_ADDR']);
        $this->addUserFailedLogins();
        $this->save();
    }
}