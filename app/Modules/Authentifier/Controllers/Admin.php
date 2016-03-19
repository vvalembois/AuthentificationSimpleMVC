<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:50
 */

namespace Modules\Authentifier\Controllers;


use Core\Router;
use Core\View;
use Modules\Authentifier\Models\AdminModel;

class Admin extends Authentifier
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes(){
        Router::any('authentifier/admin/users_management_panel', 'Modules\Authentifier\Controllers\Admin@usersManagementPanel');
        Router::any('authentifier/admin/user_management_element', 'Modules\Authentifier\Controllers\Admin@usersManagementElement');
        Router::any('authentifier/admin/user_update_form', 'Modules\Authentifier\Controllers\Admin@userUpdateForm');
    }

    public function usersManagementPanel(){
        $data['users'] = AdminModel::selectAllUsers();
        View::renderTemplate('header');
        View::renderModule('/Authentifier/Views/Admin/users_management_panel_header', $data);
        $this->usersManagementElement(AdminModel::selectAllUsers());
        View::renderModule('/Authentifier/Views/Admin/users_management_panel_footer', $data);
        View::renderTemplate('footer');
    }

    public function usersManagementElement($users){
        foreach($users as $user)
            View::renderModule('/Authentifier/Views/Admin/users_management_element', $user);
    }

    public function userUpdateForm(){
        //TODO
    }
}