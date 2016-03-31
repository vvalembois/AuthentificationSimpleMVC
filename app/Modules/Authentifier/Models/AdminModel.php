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
    public function updateAccountType($new_account_type){
        $this->setUserAccountType($new_account_type);
        $this->save();
    }
}