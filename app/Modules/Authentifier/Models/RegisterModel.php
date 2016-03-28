<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Helpers\Data;
use Helpers\RainCaptcha;
use Helpers\Request;
use Helpers\Database;
use Modules\Authentifier\Helpers\InputValidation;

class RegisterModel extends UserModel
{
    public static function insertUser($user_data){
        Database::get()->insert(PREFIX.'users', $user_data);
        return RegisterModel::findByUserID(Database::get()->lastInsertId('user_id'));
    }

    public function setUserActive($user_activation_hash){
        if($this->checkUserActivationHash($user_activation_hash)) {
            Database::get()->update('users', array('user_active' => 1), array('user_id' => $this->user_id));
            return true;
        }
        return false;
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