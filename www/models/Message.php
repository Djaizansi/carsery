<?php
namespace carsery\models;

use carsery\models\Model;
use carsery\core\Helpers;

class Message extends Model{

    protected $id;
    protected $message;
    protected $article;
    protected $author;
    protected $creation_date;
    protected $modification_date;

    public function initRelation(): array {
        return [
            'article' => Article::class,
            'author' => User::class
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * @param mixed $creation_date
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }

    /**
     * @return mixed
     */
    public function getModificationDate()
    {
        return $this->modification_date;
    }

    /**
     * @param mixed $modification_date
     */
    public function setModificationDate($modification_date)
    {
        $this->modification_date = $modification_date;
    }

}