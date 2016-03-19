<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:50
 */

namespace Modules\Authentifier\Controllers;


class Admin extends Authentifier
{
    public function routes(){
        Router::any('authentifier/admin/users_management_panel', 'Modules\Authentifier\Controllers\Authentifier@usersManagementPanel');
        Router::any('authentifier/admin/user_management_element', 'Modules\Authentifier\Controllers\Authentifier@usersManagementElement');
        Router::any('authentifier/admin/user_update_form', 'Modules\Authentifier\Controllers\Authentifier@userUpdateForm');
    }

    public function usersManagementPanel(){
        //TODO
    }

    public function usersManagementElement(){
        //TODO
    }

    public function userUpdateForm(){
        //TODO
    }
}