<?php

class Page extends BaseSql  {

    protected $id = -1;
    protected $title;
    protected $content;
    protected $hasNews;
    protected $hasEvent;
    protected $isDeleted;


    public function __construct($id = -1, $content = null, $author = null, $status = 0, $hasEvent = 1, $hasNews =1) {
        parent::__construct();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIsDeleted($isDeleted) {
        $this->isDeleted = $isDeleted;
    }

    public function getIsDeleted() {
        return $this->isDeleted;
    }

    public function getHasNews() {
        return $this->hasNews;
    }

    public function setHasNews($hasNews) {
        $this->id = $hasNews;
    }

    public function getHasEvent() {
        return $this->hasEvent;
    }

    public function setHasEvent($hasEvent) {
        $this->id = $hasEvent;
    }

    public function setContent($content) {
            $this->content = trim($content);
    }

    public function getContent() {
        return $this->content;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
            $this->title = trim($title);
    }

    public function getDateInserted() {
        return $this->dateInserted;
    }

    public function getDateUpdated() {
        return $this->dateUpdated;
    }

    public function setDateInserted($dateInserted) {
        $this->dateInserted = $dateInserted;
    }

    public function setDateUpdated($dateUpdated) {
        $this->dateUpdated = $dateUpdated;
    }

    public function getFormPageHomeUpdate($id,$title,$content,$includeNews,$includeEvent) {
        return [
            "options" => [
                "method" => "POST",
                "action" => "../pageUpdate/".$id,
                "class" => "form-group",
                "id" => "addPage",
                "optionName" => "type"
            ],
            "struct" => [
                "title" => [
                    "type" => "text",
                    "placeholder" => "Titre de l'article",
                    "required" => true,
                    "value" => "".$title.""
                ],
                "content" => [
                    "type" => "textarea",
                    "placeholder" => "Content de votre page",
                    "required" => true,
                    "value" => "".$content.""
                ],
                "includeNews" => [
                    "type" => "checkbox",
                    "name" => "news",
                    "label" => "Inclure l'article la plus récente",
                    "required" => false,
                    "value" => "".$includeNews.""
                ],
                "includeEvent" => [
                    "type" => "checkbox",
                    "name" => "news",
                    "label" => "Inclure les evenements la plus récente",
                    "required" => false,
                    "value" => "".$includeEvent.""
                ],
            ]
        ];
    }

    public function getFormSimplePageUpdate($id,$title,$content) {
        return [
            "options" => [
                "method" => "POST",
                "action" => "../pageUpdate/".$id,
                "class" => "form-group",
                "id" => "addPage",
                "optionName" => "type"
            ],
            "struct" => [
                "title" => [
                    "type" => "text",
                    "placeholder" => "Titre de l'article",
                    "required" => true,
                    "value" => "".$title.""
                ],
                "content" => [
                    "type" => "textarea",
                    "placeholder" => "Content de votre page",
                    "required" => true,
                    "value" => "".$content.""
                ],
            ]
        ];
    }

}