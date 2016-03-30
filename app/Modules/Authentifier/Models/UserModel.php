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
    protected $user_password_reset_timestamp;
    protected $user_provider_type;

    public function getArray(){
        $result = get_object_vars($this);
        unset($result['db']);
        return $result;
    }

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

    public function checkUserRememberMeToken($remember_me_token){
        return $this->user_remember_me_token == $remember_me_token;
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

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @param mixed $user_password_hash
     */
    public function setUserPasswordHash($user_password_hash)
    {
        $this->user_password_hash = $user_password_hash;
    }

    /**
     * @param mixed $user_email
     */
    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;
    }

    /**
     * @param mixed $user_active
     */
    public function setUserActive($user_active)
    {
        $this->user_active = $user_active;
    }

    /**
     * @param mixed $user_deleted
     */
    public function setUserDeleted($user_deleted)
    {
        $this->user_deleted = $user_deleted;
    }

    /**
     * @param mixed $user_account_type
     */
    public function setUserAccountType($user_account_type)
    {
        $this->user_account_type = $user_account_type;
    }

    /**
     * @param mixed $user_has_avatar
     */
    public function setUserHasAvatar($user_has_avatar)
    {
        $this->user_has_avatar = $user_has_avatar;
    }

    /**
     * @param mixed $user_remember_me_token
     */
    public function setUserRememberMeToken($user_remember_me_token)
    {
        $this->user_remember_me_token = $user_remember_me_token;
    }

    /**
     * @param mixed $user_creation_timestamp
     */
    public function setUserCreationTimestamp($user_creation_timestamp)
    {
        $this->user_creation_timestamp = $user_creation_timestamp;
    }

    /**
     * @param mixed $user_suspension_timestamp
     */
    public function setUserSuspensionTimestamp($user_suspension_timestamp)
    {
        $this->user_suspension_timestamp = $user_suspension_timestamp;
    }

    /**
     * @param mixed $user_last_login_timestamp
     */
    public function setUserLastLoginTimestamp($user_last_login_timestamp)
    {
        $this->user_last_login_timestamp = $user_last_login_timestamp;
    }

    /**
     * @param mixed $user_failed_logins
     */
    public function setUserFailedLogins($user_failed_logins)
    {
        $this->user_failed_logins = $user_failed_logins;
    }

    /**
     * @param mixed $user_last_failed_login
     */
    public function setUserLastFailedLogin($user_last_failed_login)
    {
        $this->user_last_failed_login = $user_last_failed_login;
    }

    /**
     * @param mixed $user_last_failed_login_ip
     */
    public function setUserLastFailedLoginIp($user_last_failed_login_ip)
    {
        $this->user_last_failed_login_ip = $user_last_failed_login_ip;
    }

    /**
     * @param mixed $user_activation_hash
     */
    public function setUserActivationHash($user_activation_hash)
    {
        $this->user_activation_hash = $user_activation_hash;
    }

    /**
     * @param mixed $user_password_reset_hash
     */
    public function setUserPasswordResetHash($user_password_reset_hash)
    {
        $this->user_password_reset_hash = $user_password_reset_hash;
    }

    /**
     * @param mixed $user_reset_timestamp
     */
    public function setUserResetTimestamp($user_reset_timestamp)
    {
        $this->user_reset_timestamp = $user_reset_timestamp;
    }

    /**
     * @param mixed $user_provider_type
     */
    public function setUserProviderType($user_provider_type)
    {
        $this->user_provider_type = $user_provider_type;
    }



    private function update(){
        return Database::get()->update('users', $this->getArray(), array('user_id' => $this->user_id));
    }

    private function insert(){
        Database::get()->insert(PREFIX.'users', $this->getArray());
        return RegisterModel::findByUserID(Database::get()->lastInsertId('user_id'));
    }

    public function save(){
        if($this->user_id != null){
            return $this->update();
        }
        else{
            return $this->insert();
        }
    }
}