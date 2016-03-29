<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Helpers\Database;

class AdminModel extends UserModel
{
    
    public function delete(){
        return Database::get()->delete(USERS_DB_TABLE,array('user_id'=>$this->user_id));
    }

    public function updateAccountType($new_account_type){
        Database::get()->update(USERS_DB_TABLE,array('user_account_type'=>$new_account_type), array('user_id'=>$this->user_id));
    }


    public function getArray(){
        return array(
            'user_id' => $this->user_id,
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