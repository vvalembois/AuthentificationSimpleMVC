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

    public function selectAll($user_id){
        return ($this->db->select('SELECT * FROM '.PREFIX.'users
        WHERE user_id = :user_id'
        ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)[0]
        );
    }

    public function selectProfile($user_id){
        return ($this->db->select(
            'SELECT user_id, user_name, user_email FROM '.PREFIX.'users
            WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)[0]
        );
    }

    public function selectID($user_name_or_email){
        $user_id = ($this->db->select(
            'SELECT user_id FROM '.PREFIX.'users
            WHERE user_name = :user_name_or_email
            OR user_email = :user_name_or_email'
            ,array(":user_name_or_email"=>$user_name_or_email),
            \PDO::FETCH_ASSOC)
        );
        if(!empty($user_id))
            return $user_id[0]['user_id'];
        return false;
    }

    public function exist($user_name_or_email){
        return ($this->selectID($user_name_or_email))!= false;
    }

    public function getUserPasswordHash($user_id){
        $user_password_hash = ($this->db->select(
            'SELECT user_password_hash FROM '.PREFIX.'users
            WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)
        );
        if(!empty($user_password_hash))
            return $user_password_hash[0]['user_password_hash'];
        return false;
    }

    public function checkPassword($password, $user_id){
        return password_verify($password,$this->getUserPasswordHash($user_id));
    }

    public function updateUserProfile(array $user_data_update, $profile){
        $this->db->update('users', $user_data_update,$profile);
    }

    public function selectSession($user_id){
        return ($this->db->select('SELECT session_id FROM '.PREFIX.'users
        WHERE user_id = :user_id'
            ,array(":user_id"=>$user_id),
            \PDO::FETCH_ASSOC)[0]
        );
    }

    public function sessionCheck($user_id){

    }
}