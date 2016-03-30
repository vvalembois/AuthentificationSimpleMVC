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
use Modules\Authentifier\Models\LoginModel;
use Modules\Authentifier\Models\UserModel;
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
    public function articleListElement($article){
        $user = LoginModel::findBySession();


        if ($article instanceof ArticleModel){
            if($user instanceof LoginModel && $user->getUserAccountType() > 5)
                View::render('Article/articles_list_element_admin', $article->getArray()); //avec les boutons
            else
                View::render('Article/articles_list_element', $article->getArray()); //sans les boutons
        }
    }

    public function articlesList(){
        $data['title'] = "Welcome";
        View::renderTemplate('header', $data);
        View::render('Article/articles_list_header');
        foreach ( ArticleModel::findAll() as $article){
            Article::articleListElement($article);
        }
        View::render('Article/articles_list_footer');
        View::renderTemplate('footer', $data);
    }

    /**Article Detail*/
    public function articleDetails(){
        $data['title'] = "Welcome";
        View::renderTemplate('header', $data);
        View::render('Article/article_details', ArticleModel::findById(Request::get('art_id')));
        View::renderTemplate('footer', $data);
    }

    /**Creation Article*/
    public function creationForm(){
        $this->checkRequiredUserType(2);
        $data['title'] = "Welcome";
        View::renderTemplate('header', $data);
        View::render('Article/article_creation', $data);
        View::renderTemplate('footer', $data);
    }

    public function creationAction(){
        $user = LoginModel::findBySession();
        $this->checkRequiredUserType(2);

        if($user instanceof LoginModel) {
            if (Request::post('art_titre')!= null && Request::post('art_content')!= null) {
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
        View::render('Article/article_update_form', ArticleModel::findById(Request::get('art_id')));
        View::renderTemplate('footer', $data);
    }

    public function updateAction(){
        $this->checkRequiredUserType(2);
        $article = ArticleModel::findById((Request::post('art_id')));

        if($article instanceof ArticleModel){
            $modif =false;

            if(Request::post('art_titre') !=null){
                if( Request::post("art_titre")!=null && Request::post("art_titre") != ($article-> getArtTitle())){
                    $article->setArtTitle(Request::post('art_titre'));
                    $modif=true;
                }
            }

            if(Request::post('art_titre') != null){
                if(Request::post("art_content") !=null && Request::post("art_titre") != ($article-> getArtContent())){
                    $article->setArtContent((Request::post('art_content')));
                    $modif=true;
                }
            }

            if($modif){
                $user = LoginModel::findBySession();
                if($user instanceof LoginModel && $user->getUserId() == $article->getArtAuthor() || $user->getUserAccountType() > 5)
                    $article->save();
            }
        }

        Url::redirect();
    }

    /**Supprimer Article*/
    public function delete(){
        $this->checkRequiredUserType(2);
        $data['title'] = "Welcome";
        $article = ArticleModel::findById((Request::post('art_id')));
        if($article instanceof ArticleModel){
            $user = LoginModel::findBySession();
            if($user instanceof LoginModel && $user->getUserId() == $article->getArtAuthor() || $user->getUserAccountType() > 5)
                $article->delete();
        }
        Url::redirect();
    }
}