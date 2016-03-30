<?php
/**
 * Welcome controller
 *
 * @author David Carr - dave@daveismyname.com
 * @version 2.2
 * @date June 27, 2014
 * @date updated Sept 19, 2015
 */

namespace Controllers;

use Core\View;
use Helpers\Request;
use Helpers\Session;
use Helpers\Url;
use Models\ArticleModel;
use Modules\Authentifier\Controllers\Authentifier;
use Modules\Authentifier\Helpers\AuthMail\AuthMail;
use Modules\Authentifier\Models\LoginModel;
use Modules\Authentifier\Models\UserModelTest;

/**
 * Sample controller showing a construct and 2 methods and their typical usage.
 */
class Article extends Authentifier
{
    /*
     * methode :
     *  affichage d'un article  + view ,
     *  affichage d'une liste d'article
     *  creation d'un article + view
     *  update d'un article plus vue
     *  delete d'un article plus vue
     *
     */

    /**
     * Call the parent construct
     */

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Define Index page title and load template files
     */

    public function welcome()
    {

        $data['title'] = "Welcome";
        $data['user_status'] = (Session::get('user_name') ? Session::get('user_name') : "Visitor");
        $this->test();
        View::renderTemplate('header', $data);
        $this->feedback->render();
        View::render('index', $data);
        View::renderTemplate('footer', $data);
    }

/**Article List*/
    public function articleList($article){
        if ($article instanceof ArticleModel){
            View::render('Article/articleslist', $article->getArray());
        }
    }

    public function articles(){
        $data['title'] = "Welcome";
        View::renderTemplate('header', $data);
        foreach ( ArticleModel::findAll() as $article){
            Article::articleList($article);
        }
        View::renderTemplate('header', $data);
    }

/**Article Detail*/
    public function articleDetails(){
        $data['title'] = "Welcome";
        View::renderTemplate('header', $data);
        View::render('Article/articlesdetail', ArticleModel::findById(Request::get('art_id')));
        View::renderTemplate('header', $data);
    }

/**Creation Article*/
    public function creationForm(){
        $this->checkRequiredUserType(2);
        $data['title'] = "Welcome";
        View::renderTemplate('header', $data);
        View::render('Article/creation', $data);
        View::renderTemplate('footer', $data);
    }

    public function creationAction(){
        $user = LoginModel::findBySession();
        $this->checkRequiredUserType(2);

        if($user instanceof LoginModel) {
            if ( Request::post('art_titre')!= null && Request::post('art_content')!= null) {
                $new_article = new ArticleModel();
                $new_article->setArtTitle(Request::post('art_titre'));
                $new_article->setArtAuthor($user->getUserId());
                $new_article->setArtContent(Request::post('art_content'));
                $new_article->save();
            }
        }

        Url::redirect();
    }

/**Update Article*/
    public function updateForm(){
        $this->checkRequiredUserType(2);
        $data['title'] = "Welcome";
        View::renderTemplate('header', $data);
        View::render('Article/update', ArticleModel::findById(Request::get('art_id')));
        View::renderTemplate('footer', $data);
    }

    public function updateAction(){
        $user = LoginModel::findBySession();
        $this->checkRequiredUserType(2);

        $article = ArticleModel::findById($_GET['art_id']);

        $modif =false;

        if(Request::post('art_titre') !=null){
            if( Request::post("art_titre")!=null && Request::post("art_titre") != ($article-> getArtTitle())){
                $article->setArtTitle(Request::post('art_titre'));
                $modif=true;
            }
        }

        if(Request::post('art_titre') != null){
            if(Request::post("art_content") !=null && Request::post("art_titre") != ($article-> getArtContent())){
                $article->setArtContent($_POST["art_content"]);
                $modif=true;
            }
        }

        if($modif) $article->save();

        Url::redirect();
    }

/**Supprimer Article*/
    public function delete(){
        $this->checkRequiredUserType(2);
        $data['title'] = "Welcome";



        Url::redirect();
    }

}
