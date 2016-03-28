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

define('USERS_DB_TABLE','users');

abstract class UserModel extends Model
{
    protected $user_id;
    protected $user_name;
    protected $session_id;
    protected $user_password_hash;
    protected $user_email;
    protected $user_active;
    protected $user_deleted;
    protected $user_account_type;
    protected $user_has_avatar;
    protected $user_remember_me_token;
    protected $user_creation_timestamp;
    protected $user_suspension_timestamp;
    protected $user_last_login_timestamp;
    protected $user_failed_logins;
    protected $user_last_failed_login;
    protected $user_last_failed_login_ip;
    protected $user_activation_hash;
    protected $user_password_reset_hash;
    protected $user_reset_timestamp;
    protected $user_provider_type;

    abstract public function getArray();

    public static function findByUserName($user_name){
        $user_sql = Database::get()->select('SELECT * FROM '.PREFIX.USERS_DB_TABLE.' WHERE user_name = "'.$user_name.'";',array(),\PDO::FETCH_CLASS, static::class);
        return (!empty($user_sql) ? $user_sql[0] : null);
    }

    public static function findByUserEMail($user_email){
        $user_sql = Database::get()->select('SELECT * FROM '.PREFIX.'users WHERE user_email ="'.$user_email.'";',array(),\PDO::FETCH_CLASS, static::class);
        return (!empty($user_sql) ? $user_sql[0] : null);
    }

    public static function findByUserID($user_id){
        $user_sql = Database::get()->select('SELECT * FROM '.PREFIX.'users WHERE user_id ="'.$user_id.'";',array(),\PDO::FETCH_CLASS, static::class);
        return (!empty($user_sql) ? $user_sql[0] : null);
    }

    public static function findAll(){
        $user_sql = Database::get()->select('SELECT * FROM '.PREFIX.'users ;',array(),\PDO::FETCH_CLASS, static::class);
        return (!empty($user_sql) ? $user_sql : null);
    }


    /**
     * @return mixed
     */
    public function getUserSuspensionTimestamp()
    {
        return $this->user_suspension_timestamp;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @return mixed
     */
    public function checkSessionId($session_id)
    {
        return $this->session_id == $session_id;
    }

    public function setSessionId($session_id){
        $this->session_id = $session_id;
    }

    /**
     * @return mixed
     */
    public function checkUserPassword($user_password)
    {
        return password_verify($user_password, $this->user_password_hash);
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * @return mixed
     */
    public function checkUserActive()
    {
        return $this->user_active != 0 ;
    }

    /**
     * @return mixed
     */
    public function getUserDeleted()
    {
        return $this->user_deleted;
    }

    /**
     * @return mixed
     */
    public function getUserAccountType()
    {
        return $this->user_account_type;
    }

    /**
     * @return mixed
     */
    public function getUserHasAvatar()
    {
        return $this->user_has_avatar;
    }

    /**
     * @return mixed
     */
    public function getUserRememberMeToken()
    {
        return $this->user_remember_me_token;
    }

    /**
     * @return mixed
     */
    public function getUserCreationTimestamp()
    {
        return $this->user_creation_timestamp;
    }

    /**
     * @return mixed
     */
    public function getUserLastLoginTimestamp()
    {
        return $this->user_last_login_timestamp;
    }

    /**
     * @return mixed
     */
    public function getUserFailedLogins()
    {
        return $this->user_failed_logins;
    }

    /**
     * @return mixed
     */
    public function getUserLastFailedLogin()
    {
        return $this->user_last_failed_login;
    }

    /**
     * @return mixed
     */
    public function getUserActivationHash()
    {
        return $this->user_activation_hash;
    }

    /**
     * @return mixed
     */
    public function checkUserActivationHash($user_activation_hash)
    {
        return $user_activation_hash == $this->user_activation_hash;
    }

    /**
     * @return mixed
     */
    public function checkUserPasswordResetHash($user_password_reset_hash)
    {
        return $this->user_password_reset_hash == $user_password_reset_hash;
    }

    /**
     * @return mixed
     */
    public function getUserResetTimestamp()
    {
        return $this->user_reset_timestamp;
    }

    /**
     * @return mixed
     */
    public function getUserProviderType()
    {
        return $this->user_provider_type;
    }

    public function save(){
        Database::get()->update('users',$this->getArray(),array('user_id' => $this->user_id));
    }
}