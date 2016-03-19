<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:50
 */

namespace Modules\Authentifier\Controllers;


use Core\View;

class Admin extends Authentifier
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(){
        Router::any('authentifier/admin/users_management_panel', 'Modules\Authentifier\Controllers\Authentifier@usersManagementPanel');
        Router::any('authentifier/admin/user_management_element', 'Modules\Authentifier\Controllers\Authentifier@usersManagementElement');
        Router::any('authentifier/admin/user_update_form', 'Modules\Authentifier\Controllers\Authentifier@userUpdateForm');
    }
   
    public function usersManagementPanel(){
        $data['users'] = AdminModel::selectAllUsers();
        View::renderTemplate('header');
        View::renderModule('/Authentifier/Views/Admin/susers_management_panel_header', $data);
        $this->usersManagementElement(/*ta fonction dans AdminModel*/);
        View::renderModule('/Authentifier/Views/Admin/susers_management_panel_footer', $data);
        View::renderTemplate('footer');
    }

    public function usersManagementElement($users){
        foreach($users as $user)
            View::renderModule('/Authentifier/Views/Admin/susers_management_element', $user);
    }

    public function userUpdateForm(){
        //TODO
    }
}