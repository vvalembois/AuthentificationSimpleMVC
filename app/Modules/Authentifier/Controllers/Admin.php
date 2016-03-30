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
use Helpers\Session;
use Helpers\Url;
use Modules\Authentifier\Models\AdminModel;
use Modules\Authentifier\Models\LoginModel;

class Admin extends Authentifier
{
    public function __construct()
    {
        parent::__construct(125);
    }

    public function routes(){
        Router::any('authentifier/admin/users_management_panel', 'Modules\Authentifier\Controllers\Admin@usersManagementPanel');
        Router::post('authentifier/admin/users_management_panel_action', 'Modules\Authentifier\Controllers\Admin@usersManagementPanelAction');
        Router::post('authentifier/admin/users_management_delete_action', 'Modules\Authentifier\Controllers\Admin@usersManagementDeleteAction');
        Router::post('/authentifier/admin/users_management_update_action', 'Modules\Authentifier\Controllers\Admin@usersManagementUpdateAction');

    }

    public function usersManagementPanel(){
        $this->checkRequiredUserType();
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");

        $user_list = AdminModel::findAll();
        $data['count_users'] = count($user_list);


        View::renderTemplate('header',$data);
        $this->feedback->render();
        View::renderModule('/Authentifier/Views/Admin/users_management_panel_header', $data);
        $this->usersManagementElement($user_list);
        View::renderModule('/Authentifier/Views/Admin/users_management_panel_footer', $data);
        View::renderTemplate('footer');
    }

    public function usersManagementElement(array $users){
        $this->checkRequiredUserType();
        if(!empty($users))
            foreach($users as $user)
                if($user instanceof AdminModel) {
                    $user_owner = LoginModel::findBySession();
                    if($user_owner instanceof LoginModel) {
                        if ($user->getUserAccountType() < $user_owner->getUserAccountType() || $user->getUserId() == $user_owner->getUserId())
                            View::renderModule('/Authentifier/Views/Admin/users_management_element', $user->getArray());
                        else
                            View::renderModule('/Authentifier/Views/Admin/users_management_element_not_update_available', $user->getArray());
                    }
                }

    }

    public function userUpdateForm(){
        $this->checkRequiredUserType();
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");
        //TODO
    }

    public function usersManagementPanelAction(){
        $this->checkRequiredUserType();
        $user_id = Request::post('user_id');
        $action = Request::post('action');
        if(isset($user_id) && isset($action)){
            $user = AdminModel::findByUserID($user_id);

            if($user instanceof AdminModel) {
                if($user->getUserId() != LoginModel::findBySession()->getUserId())
                    $this->checkRequiredUserType($user->getUserAccountType()+1); // You can update a user only if he have an inferior greats level
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
        $this->checkRequiredUserType();
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");
        View::renderTemplate('header',$data);
        $this->feedback->render();

        $data['user_id'] = $user->getUserId();
        $data['user_name'] = $user->getUserName();
        View::renderModule('/Authentifier/Views/Admin/users_management_delete_confirmation', $data);

        View::renderTemplate('footer');

    }

    public function usersManagementDeleteAction(){
        $this->checkRequiredUserType();
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
        $this->checkRequiredUserType();
        View::renderTemplate('header');
        $this->feedback->render();

        $data = $user->getArray();
        View::renderModule('/Authentifier/Views/Admin/users_management_update_panel', $data);

        View::renderTemplate('footer');
    }

    public function usersManagementUpdateAction(){
        $this->checkRequiredUserType();
        $user_id = Request::post('user_id');
        if(isset($user_id)) {
            $user = AdminModel::findByUserID($user_id);
            if ($user instanceof AdminModel) {
                //changement
                //TODO

                //si il y a changement
                    $this->feedback->add('User '.$user->getUserName().' updated.',FEEDBACK_TYPE_SUCCESS);
            }
            //si pas changement
            else{
                $this->feedback->add('User '.$user->getUserName().' not updated.',FEEDBACK_TYPE_INFO);
            }
        }
        Url::redirect('authentifier/admin/users_management_panel');
    }

    private function usersManagementDetails(AdminModel $user){
        $this->checkRequiredUserType();
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");
        View::renderTemplate('header',$data);
        $this->feedback->render();

        $data = $user->getArray();
        View::renderModule('/Authentifier/Views/Admin/users_management_details_panel', $data);

        View::renderTemplate('footer');
        // TODO afficher le profil de l'utilisateur en question
    }
}