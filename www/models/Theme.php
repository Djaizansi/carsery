<?php

namespace carsery\models;

class Theme extends Model
{
    protected $id;
    protected $title;
    protected $content;
    protected $thumbnail;

    public function initRelation(): array {
        return [
        
        ];
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title=$title;
    }
    public function setContent($content)
    {
        $this->content=$content;
    }
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail=$thumbnail;
    }
}