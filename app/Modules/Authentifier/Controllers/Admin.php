<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:50
 */

namespace Modules\Authentifier\Controllers;

use Core\Router;
use Core\View;
use Modules\Authentifier\Helpers\Feedback;
use Modules\Authentifier\Models\AdminModel;

class Admin extends Authentifier
{
    public function __construct()
    {
        parent::__construct();
    }

    public function routes()
    {
        Router::any('authentifier/index', 'Modules\Authentifier\Controllers\Admin@index');
    }

    public function index(){
        $data['users'] = AdminModel::selectAllUsers();
        View::renderTemplate('header');
        View::renderModule('/Authentifier/Views/Admin/index', $data);
        View::renderTemplate('footer');
    }
}