<?php

namespace carsery\models;

class Shortcode extends Model{

    protected $id;
    protected $shortcode;
    protected $description;
    protected $images;
    protected $type;

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
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of shortcode
     */ 
    public function getShortcode()
    {
        return $this->shortcode;
    }

    /**
     * Set the value of shortcode
     *
     * @return  self
     */ 
    public function setShortcode($shortcode)
    {
        $this->shortcode = $shortcode;

        return $this;
    }
    
    /**
     * Get the value of images
     */ 
    public function getImages()
    {
        return $this->images;
    }
    /**
     * Set the value of images
     *
     * @return  self
     */ 
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}