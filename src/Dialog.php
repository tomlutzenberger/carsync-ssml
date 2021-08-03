<?php

namespace TomLutzenberger\CarSyncSsml;

class Dialog
{

    private string $type;
    private string $tag;
    private string $content;
    private array  $attributes;


    public function __construct(string $type, string $tag, string $content, array $attributes)
    {
        $this->type = $type;
        $this->tag = $tag;
        $this->content = $content;
        $this->attributes = $attributes;
    }


    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }


    /**
     * @param string $type
     */
    public function setType(string $type) : void
    {
        $this->type = $type;
    }


    /**
     * @return string
     */
    public function getTag() : string
    {
        return $this->tag;
    }


    /**
     * @param string $tag
     */
    public function setTag(string $tag) : void
    {
        $this->tag = $tag;
    }


    /**
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }


    /**
     * @param string $content
     */
    public function setContent(string $content) : void
    {
        $this->content = $content;
    }


    /**
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }


    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes) : void
    {
        $this->attributes = $attributes;
    }

}
