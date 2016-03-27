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

class LoginModel extends UserModelTest
{
    public static function userIsLoggedIn()
    {
        $user_id = Session::get('user_id');
        return self::checkLoginSession($user_id, Session::id());
    }

    public function connection(){
        Session::regenerate();
        $this->session_id = Session::id();
        Database::get()->update('users', array('session_id'=>$this->session_id, 'user_failed_logins'=>0), array('user_id' => $this->user_id));
    }

    public function loginFailed(){
        $this->user_failed_logins ++;////////
        $this->user_last_failed_login = time();//////
        $this->user_last_failed_login_ip = $_SERVER['REMOTE_ADDR'];
        Database::get()->update('users',array('user_failed_logins'=>$this->user_failed_logins, 'user_last_failed_login'=>$this->user_last_failed_login, 'user_last_failed_login_ip'=>$this->user_last_failed_login_ip),array('user_id' => $this->user_id));
    }

    public static function checkLoginSession($user_id, $session_id){
        $user = UserModelTest::findByUserID($user_id);
        return ($user ? $user->checkSessionId($session_id) : false);
    }
}