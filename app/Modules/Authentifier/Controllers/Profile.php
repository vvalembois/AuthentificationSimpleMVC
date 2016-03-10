<?php
/**
 * User: deloffre
 * Date: 21/02/16
 * Time: 19:50
 */

namespace Modules\Authentifier\Controllers;


class Profile extends Authentifier
{

    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function routes()
    {
        Router::any('authentifier/profileForm', 'Modules\Authentifier\Controllers\Profiler@profileForm');
        Router::any('authentifier/profileAction', 'Modules\Authentifier\Controllers\Profile@profileAction');
    }
    
    public function profileForm()
    {
        View::renderTemplate('header');
        $this->feedback->render();
        View::renderModule('/Authentifier/Views//', $data);
        View::renderTemplate('footer');
    }
    
    public function profileAction()
    {
        View::renderTemplate('header');
        $this->feedback->render();
        View::renderModule('/Authentifier/Views//', $data);
        View::renderTemplate('footer');
    }

}