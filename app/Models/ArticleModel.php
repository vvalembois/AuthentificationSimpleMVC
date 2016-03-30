<?php
/**
 * User: deloffre
 * Date: 03/03/16
 * Time: 11:20
 */

namespace Models;


use Core\Model;
use Helpers\Database;

class ArticleModel extends Model
{
    private $art_id;
    private $art_title;
    private $art_author;
    private $art_creation_date;
    private $art_update_date;
    private $art_content;
    private $art_image;
    private $art_reader_counter;

    /**
     * ArticleModel constructor.
     * @param $art_title
     * @param $art_author
     * @param $art_creation_date
     * @param $art_update_date
     * @param $art_content
     * @param $art_image
     * @param $art_reader_counter
     * @param $art_id
     */
    public function __construct($art_title, $art_author, $art_creation_date, $art_update_date, $art_content, $art_image, $art_reader_counter)
    {
        $this->art_title = $art_title;
        $this->art_author = $art_author;
        $this->art_creation_date = $art_creation_date;
        $this->art_update_date = $art_update_date;
        $this->art_content = $art_content;
        $this->art_image = $art_image;
        $this->art_reader_counter = $art_reader_counter;
    }


    public static function findById($id){
        $article_sql = Database::get()->select('SELECT * FROM article WHERE art_id = "'.$id.'";',array(),\PDO::FETCH_CLASS, static::class);
        return (!empty($article_sql) ? $article_sql[0] : null);
    }

    public static function findByTitle($title){
        $article_sql = Database::get()->select('SELECT * FROM article WHERE art_title = "'.$title.'";',array(),\PDO::FETCH_CLASS, static::class);
        return (!empty($article_sql) ? $article_sql[0] : null);
    }

    public static function findByAuthor($author_id){
        $article_sql = Database::get()->select('SELECT * FROM article WHERE art_author = "'.$author_id.'";',array(),\PDO::FETCH_CLASS, static::class);
        return (!empty($article_sql) ? $article_sql[0] : null);
    }

    public static function findAll(){
        $article_sql = Database::get()->select('SELECT * FROM article',array(),\PDO::FETCH_CLASS, static::class);
        return (!empty($article_sql) ? $article_sql : null);
    }

    public function getArray(){
        return array(
            'art_title' => $this->art_title,
            'art_author' => $this->art_author,
            'art_creation_date' => $this->art_creation_date,
            'art_update_date' => $this->art_update_date,
            'art_content' => $this->art_content,
            'art_image' => $this->art_image,
            'art_reader_counter' => $this->art_reader_counter,
        );
    }

    public function insertArticle($article){
        Database::get()->insert('article', $article->getArray());
        return ArticleModel::findById(Database::get()->lastInsertId('art_id'));
    }

    /**
     * @return mixed
     */
    public function getArtId()
    {
        return $this->art_id;
    }

    /**
     * @return mixed
     */
    public function getArtTitle()
    {
        return $this->art_title;
    }

    /**
     * @return mixed
     */
    public function getArtAuthor()
    {
        return $this->art_author;
    }

    /**
     * @return mixed
     */
    public function getArtCreationDate()
    {
        return $this->art_creation_date;
    }

    /**
     * @return mixed
     */
    public function getArtUpdateDate()
    {
        return $this->art_update_date;
    }

    /**
     * @return mixed
     */
    public function getArtContent()
    {
        return $this->art_content;
    }

    /**
     * @return mixed
     */
    public function getArtImage()
    {
        return $this->art_image;
    }

    /**
     * @return mixed
     */
    public function getArtReaderCounter()
    {
        return $this->art_reader_counter;
    }


}