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
}