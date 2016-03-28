<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:50
 */

namespace Modules\Authentifier\Controllers;


use Core\Router;
use Core\View;
use Helpers\Request;
use Helpers\Url;
use Modules\Authentifier\Models\AdminModel;

class Admin extends Authentifier
{
    public function __construct()
    {
        parent::__construct(2);
    }

    public function routes(){
        Router::any('authentifier/admin/users_management_panel', 'Modules\Authentifier\Controllers\Admin@usersManagementPanel');
        Router::post('authentifier/admin/users_management_panel_action', 'Modules\Authentifier\Controllers\Admin@usersManagementPanelAction');
        Router::post('authentifier/admin/users_management_delete_action', 'Modules\Authentifier\Controllers\Admin@usersManagementDeleteAction');
    }

    public function usersManagementPanel(){
        $this->checkAccountTypeRequired();
        View::renderTemplate('header');
        View::renderModule('/Authentifier/Views/Admin/users_management_panel_header', $data);
        $this->feedback->render();
        $this->usersManagementElement(AdminModel::listUsers());
        View::renderModule('/Authentifier/Views/Admin/users_management_panel_footer', $data);
        View::renderTemplate('footer');
    }

    public function usersManagementElement($users){
        $this->checkAccountTypeRequired();
        if(!empty($users))
            foreach($users as $user)
                View::renderModule('/Authentifier/Views/Admin/users_management_element', $user);
    }

    public function userUpdateForm(){
        //TODO
    }

    public function usersManagementPanelAction(){
        $this->checkAccountTypeRequired();
        $user_id = Request::post('user_id');
        $action = Request::post('action');
        if(isset($user_id) && isset($action)){
            $user = AdminModel::findByUserID($user_id);
            if($user instanceof AdminModel) {
                if ($action == 'delete') {
                    $this->usersManagementDeleteConfirmation($user);
                } elseif ($action == 'update') {
                    $this->usersManagementUpdate($user);
                } elseif ($action == 'details') {
                    $this->usersManagementDetails($user);
                }
            }
        }
    }

    private function usersManagementDeleteConfirmation(AdminModel $user){
        $this->checkAccountTypeRequired();
        View::renderTemplate('header');
        $this->feedback->render();

        $data['user_id'] = $user->getUserId();
        $data['user_name'] = $user->getUserName();
        View::renderModule('/Authentifier/Views/Admin/users_management_delete_confirmation', $data);

        View::renderTemplate('footer');

    }

    public function usersManagementDeleteAction(){
        $this->checkAccountTypeRequired();
        $user_id = Request::post('user_id');
        $confirmed = Request::post('confirmed');
        if(isset($user_id) && isset($confirmed)) {
            $user = AdminModel::findByUserID($user_id);
            if ($user instanceof AdminModel) {
                if($confirmed=='true'){
                    $user->delete();
                    $this->feedback->add('User '.$user->getUserName().' deleted.',FEEDBACK_TYPE_SUCCESS);
                }

                else{
                    $this->feedback->add('User '.$user->getUserName().' not deleted.',FEEDBACK_TYPE_INFO);
                }
            }
        }
        Url::redirect('authentifier/admin/users_management_panel');
    }

    private function usersManagementUpdate(AdminModel $user){
        $this->checkAccountTypeRequired();
        View::renderTemplate('header');
        $this->feedback->render();

        $data['user_id'] = $user->getUserId();
        $data['user_name'] = $user->getUserName();
        View::renderModule('/Authentifier/Views/Admin/users_management_update_panel', $data);

        View::renderTemplate('footer');
    }

    private function usersManagementDetails(AdminModel $user){
        $this->checkAccountTypeRequired();
        View::renderTemplate('header');
        $this->feedback->render();

        $data = $user->getArray();
        View::renderModule('/Authentifier/Views/Admin/users_management_details_panel', $data);

        View::renderTemplate('footer');
        // TODO afficher le profil de l'utilisateur en question
    }
}