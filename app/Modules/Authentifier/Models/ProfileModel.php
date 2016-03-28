<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Database;

class ProfileModel extends UserModel
{
    public static function selectAccountType($user_id){
        $accountType = (Database::get()->select(
            'SELECT user_account_type FROM '.PREFIX.'users
            WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id)
            , \PDO::FETCH_ASSOC)
        );
        if(!empty($accountType))
            return $accountType[0]['user_account_type'];
        return false;
    }

    public function updateUserProfile(array $user_data_update){
        return Database::get()->update('users', $user_data_update,array('user_id' => $this->user_id));
    }

    public static function selectProfile($user_id){
        return (Database::get()->select(
            'SELECT user_id, user_name, user_email FROM '.PREFIX.'users
            WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)[0]
        );
    }

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
}