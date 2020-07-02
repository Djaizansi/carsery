<?php

namespace carsery\models;

use carsery\models\Model;
use carsery\core\Helpers;
use carsery\models\User;
use carsery\models\Category;

class Article extends Model{

	protected $id;
	protected $title;
	protected $description;
	protected $tags;
    protected $author;
    protected $category;
    protected $creation_date;
    protected $modification_date;
    protected $resolve = false;
	private $messages;
	private $nbMessages = null;

    public function initRelation(): array {
        return [
            'author' => User::class,
            'category' => Category::class,
        ];
    }
    
    public function hydrate(array $row){
        $className = get_class($this);// $className = static::class
        $articleObj = new $className();
        foreach ($row as $key => $value) {
        
            $method = 'set'.str_replace('_', '', ucwords($key, '_'));
            if (method_exists($articleObj, $method)) {
                // Author = 4
                if($relation = $articleObj->getRelation($key)) {
                    // relation = User::class (App\Model\User)
                    $tmp = new $relation();
                    $tmp = $tmp->hydrate($row);
                    // Maintenant on récupère notre id qui est ... la valeur actuelle de notre objet
                    $tmp->setId($value);
                    $articleObj->$method($tmp);
                } else {
                    $articleObj->$method($value);
                }
            } /*else {
                switch ($method){
                    case 'setMessages':
                        $message = new \Message();
                        $this->$method($message->find('*', 'forum_id', $this->getId()));
                        break;
                    case 'setNbMessages' :
                        $this->$method(count($this->getMessages()));
                        break;
                    default:
                        break;
                }

            }*/
        }

        return $articleObj;
    }

    public function setId($id)
    {
        $this->id=$id;
    }

    public function getId(){
	    return $this->id;
    }

    public function setTitle($title)
    {
        $this->title=$title;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setTags($tags)
    {
        $this->tags=$tags;
    }

    public function getTags(){
        return $this->tags;
    }

    public function setMessages($messages)
    {
        $this->messages=$messages;
    }

    public function getMessages(){
        return $this->messages;
    }

    public function setNbMessages($nbMessages)
    {
        $this->nbMessages=$nbMessages;
    }

    public function getNbMessages(){
        return $this->nbMessages;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function isResolve()
    {
        return $this->resolve;
    }

    public function setResolve($resolve)
    {
        $this->resolve = $resolve;
    }

    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;
    }

    public function getCreationDate()
    {
        return $this->creation_date;
    }

    public function setModificationDate($modification_date)
    {
        $this->modification_date = $modification_date;
    }

    public function getModificationDate()
    {
        return $this->modification_date;
    }



}