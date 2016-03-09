<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;
use Modules\Authentifier\Helpers\InputValidation;

class UserModel extends Model
{
    private $user_id;
    private $user_name;
    private $session_id;
    private $user_password_hash;
    private $user_email;
    private $user_active;
    private $user_deleted;
    private $user_account_type;
    private $user_has_avatar;
    private $user_remember_me_token;
    private $user_creation_timestamp;
    private $user_suspension_timestamp;
    private $user_last_login_timestamp;
    private $user_failed_logins;
    private $user_last_failed_logins;
    private $user_activation_hash;
    private $user_password_reset_hash;
    private $user_reset_timestamp;
    private $user_provider_type;

    public function insertUser($user_data){
        $this->db->insert(PREFIX.'users', $user_data);
        return $this->db->lastInsertId('user_id');
    }

    public function exist($user_name_or_email){
        return($this->db->select(
            "SELECT 1 FROM ".PREFIX."users
             WHERE user_name = :user_name_or_email
                    OR user_email = :user_name_or_email
            ",array(":user_name_or_email"=>$user_name_or_email))
        );
    }
}