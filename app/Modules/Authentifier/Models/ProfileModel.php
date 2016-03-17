<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Core\Model;

class ProfileModel extends Model
{
    public function selectAccountType($user_id){
        $accountType = ($this->db->select(
            'SELECT user_account_type FROM '.PREFIX.'users
            WHERE user_id = $user_id'
            , \PDO::FETCH_ASSOC)
        );
        if(!empty($accountType))
            return $accountType;
        return false;
    }
}