<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Database;
use Helpers\Session;
use Modules\Authentifier\Controllers\User;
use Modules\Authentifier\Helpers\Cookies;

class LoginModel extends UserModel
{


    public function getArray(){
        return array(
            'user_name' => $this->user_name,
            'session_id' => $this->session_id,
            'user_email' => $this->user_email,
            'user_password_hash' => $this->user_password_hash,
            'user_active' => $this->user_active,
            'user_deleted' => $this->user_deleted,
            'user_account_type' => $this->user_account_type,
            'user_has_avatar' => $this->user_has_avatar,
            'user_remember_me_token' => $this->user_remember_me_token,
            'user_activation_hash' => $this->user_activation_hash,
            'user_last_failed_login_ip' => $this->user_last_failed_login_ip
        );
    }


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
        $this->session_id = Session::id();
        $update_data = array('session_id'=>$this->session_id, 'user_failed_logins'=>0, 'user_last_login_timestamp' => time());
        if(isset($cookie_token))
            $update_data['user_remember_me_token']=$cookie_token;
        Database::get()->update('users', $update_data, array('user_id' => $this->user_id));
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
        $this->user_failed_logins ++;////////
        $this->user_last_failed_login = time();//////
        $this->user_last_failed_login_ip = $_SERVER['REMOTE_ADDR'];
        Database::get()->update('users',array('user_failed_logins'=>$this->user_failed_logins, 'user_last_failed_login'=>$this->user_last_failed_login, 'user_last_failed_login_ip'=>$this->user_last_failed_login_ip),array('user_id' => $this->user_id));
    }
}