<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Modules\Authentifier\Models;


use Helpers\Database;

class AdminModel extends UserModelTest
{
    public static function listUsers(){
        $users = array();
        foreach(static::findAll() as $user){
            $users[] = array('user_id'=>$user->user_id, 'user_name'=>$user->user_name, 'user_email'=>$user->user_email);
        }
        if(!empty($users))
            return $users;
        return null;
    }
    
    public function delete(){
        return Database::get()->delete(USERS_DB_TABLE,array('user_id'=>$this->user_id));
    }

    public function updateAccountType($new_account_type){
        Database::get()->update(USERS_DB_TABLE,array('user_account_type'=>$new_account_type), array('user_id'=>$this->user_id));
    }
}