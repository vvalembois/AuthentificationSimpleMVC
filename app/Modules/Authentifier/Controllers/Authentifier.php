<?php
namespace Modules\Authentifier\Controllers;

use Core\Controller;
use Core\Router;
use Core\View;
use Helpers\Session;
use Helpers\Url;
use Modules\Authentifier\Models\LoginModel;
use Modules\Authentifier\Models\UserModel;
use Modules\Feedback\Helpers\Feedback;

/**
 * Class Authentifier
 * This class extend Controller and you have to use it for all controller you wan't to used this Authentifier module
 * In your controller, you have to use the method $this->checkRequiredUserType(int|false) if you want to control access to controller method
 * For setting the default required user type of your controller, you have to call the parent(this class) constructor with an integer as parameter (look on the $requider_user_type attribute of this class commentary)
 * @package Modules\Authentifier\Controllers
 */
class Authentifier extends Controller{

    /**
     * @var Feedback the current feedback
     */
	protected $feedback;

    /**
     * This value is the default minimum account type required for this controller methods
     * By default, authentifier use 5 types, you can use values into 2 to 124 for custom types without problems:
     * - 0          ->    simple visitor    :    not logged in
     * - 1          ->    user              :    logged in
     * - 2 to 124   ->    custom types      :    you can uses theses values for customised account type (subscriber, premium, VIP, ...)
     * - 125        ->    administrator 0   :    they can manage 0 to 124 account types (used for the controller Admin for example)
     * - 126        ->    administrator 1   :    they can manage 0 to 125 account (they can manage administrator 0)
     * - 127        ->    master            :    normally just one, he can manage all account type
     * @var int between 0 (simple visitor, not logged in) to 127(Master)
     */
    protected $required_user_type;

    protected $user_logged;

    /**
     * @param int into 0 to 127 $required_user_type (look on the $requider_user_type attribute of this class commentary)
     */
	public function __construct($required_user_type = 0){
		parent::__construct();
		// Initialisation d'une session
		Session::init();

		// Tester si une session existe, la garder si elle est bonne, la detruire si elle est mauvaise
		$this->user_logged = LoginModel::userLoggedIn();

		if(!isset($this->feedback))
			$this->feedback = new Feedback();

        // set the required user type
        $this->required_user_type = $required_user_type;

	}
	
	public function routes(){
		Router::any('authentifier', 'Modules\Authentifier\Controllers\Authentifier@test');
	}

    /**
     * You need to use this function on the begin of your controller method which required a certain account type
     * You can initialise a default required account type with the constructor parameter $required_user_type or use a new with this method param
     * @param int(into 0 to 127, for know what you can use you have to see on $required_used_type attribute of this class)|false $required_user_type the minimum required user type for have right to continue
     * @return bool true if the users have required right, else false
     */
    protected function checkRequiredUserType($required_user_type = false){
        if(!$required_user_type)
            $required_user_type = $this->required_user_type;

        if ($required_user_type <= 0 || ($this->user_logged instanceof UserModel && $this->user_logged->getUserAccountType() >= $required_user_type))
            return true;
        if ($required_user_type == 1)
            $this->feedback->add("You need to be logged to visit this part of the site", FEEDBACK_TYPE_FAIL);
        else
            $this->feedback->add('You can\'t visit this part of the site without the good right level', FEEDBACK_TYPE_FAIL);
        Url::redirect();
        return false;
    }

    /**
     * An experimental render method
     * You can use this render instead of checkRequiredUserType(false) and View::render()
     * @param $path
     * @param bool|false $data
     * @param bool|false $error
     */
    protected function render($path, $data = false, $error = false){
        $this->checkRequiredUserType();
        View::render($path, $data = false, $error = false);
    }

    /**
     * An experimental render module method
     * You can use this render instead of checkRequiredUserType(false) and View::renderModule()
     * @param $path
     * @param bool|false $data
     * @param bool|false $error
     */
    protected function renderModule($path, $data = false, $error = false){
        $this->checkRequiredUserType();
        View::renderModule($path, $data = false, $error = false);
    }

    /**
     * An experimental render template method
     * You can use this render instead of checkRequiredUserType(false) and View::renderTemplate()
     * @param $path
     * @param bool|false $data
     * @param bool|false $error
     */
    protected function renderTemplate($path, $data = false, $error = false){
        $this->checkRequiredUserType();
        View::renderTemplate($path, $data = false, $error = false);
    }

}
