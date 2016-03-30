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

    public static function findById($id){
        $article_sql = Database::get()->select('SELECT * FROM article WHERE art_id = "'.$id.'";',array(),\PDO::FETCH_CLASS, self::class);
        return (!empty($article_sql) ? $article_sql[0] : null);
    }

    public static function findByTitle($title){
        $article_sql = Database::get()->select('SELECT * FROM article WHERE art_title = "'.$title.'";',array(),\PDO::FETCH_CLASS, self::class);
        return (!empty($article_sql) ? $article_sql[0] : null);
    }

    public static function findByAuthor($author_id){
        $article_sql = Database::get()->select('SELECT * FROM article WHERE art_author = "'.$author_id.'";',array(),\PDO::FETCH_CLASS, self::class);
        return (!empty($article_sql) ? $article_sql[0] : null);
    }

    public static function findAll(){
        $article_sql = Database::get()->select('SELECT * FROM article',array(),\PDO::FETCH_CLASS, self::class);
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

    private function insert(){
        $this->setArtCreationDate(date('d-m-Y H:i:s'));
        Database::get()->insert('article', $this->getArray());
        return ArticleModel::findById(Database::get()->lastInsertId('art_id'));
    }

    private function update(){
        $this->setArtUpdateDate(date('d-m-Y H:i:s'));
        return Database::get()->update('article', $this->getArray(),array('art_id' => $this->art_id));
    }

    public function delete(){
        return Database::get()->delete('article',array('art_id'=>$this->art_id));
    }

    public function save(){

        if($this->art_id != null){
            $this->update();
        }
        else{
            $this->insert();
        }
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

    /**
     * @param mixed $art_title
     */
    public function setArtTitle($art_title)
    {
        $this->art_title = $art_title;
    }

    /**
     * @param mixed $art_creation_date
     */
    public function setArtCreationDate($art_creation_date)
    {
        $this->art_creation_date = $art_creation_date;
    }

    /**
     * @param mixed $art_update_date
     */
    public function setArtUpdateDate($art_update_date)
    {
        $this->art_update_date = $art_update_date;
    }

    /**
     * @param mixed $art_content
     */
    public function setArtContent($art_content)
    {
        $this->art_content = $art_content;
    }

    /**
     * @param mixed $art_image
     */
    public function setArtImage($art_image)
    {
        $this->art_image = $art_image;
    }

    /**
     * @param mixed $art_reader_counter
     */
    public function addArtReaderCounter()
    {
        $this->art_reader_counter++;
    }

    /**
     * @param mixed $art_author
     */
    public function setArtAuthor($art_author)
    {
        $this->art_author = $art_author;
    }
}