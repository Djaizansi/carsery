<?php

namespace carsery\models;

class Shortcode extends Model{

    protected $id;
    protected $shortcode;
    protected $content;

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
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
    
}