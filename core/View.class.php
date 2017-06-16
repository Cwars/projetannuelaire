<?php

class View {

    private $view;
    private $template;
    private $cat;
    private $data = array();

    public function __construct($view = "index") {
        $this->setView($view);
        $this->setTemplate();
    }

    public function setView($view) {
    switch (true) {
    case (file_exists("views/front/" . $view . ".view.php")):
        $this->view = "front/".$view;
        $this->cat = "front"; 
        break;
    case (file_exists("views/front/article/" . $view . ".view.php")):
        $this->view = "front/article/".$view;
        $this->cat = "front";
        break;
    case (file_exists("views/front/page/" . $view . ".view.php")):
        $this->view = "front/page/".$view;
        $this->cat = "front";
        break;
    case (file_exists("views/back/" . $view . ".view.php")):
        $this->view = "back/".$view;
        $this->cat = "back";
        break;
    case (file_exists("views/back/action/" . $view . ".view.php")):
        $this->view = "back/action/".$view;
        $this->cat = "back";
        break;
    }
}

    public function setTemplate() {
        if ($this->view != "back/backconnection"){
            if ($this->cat === "back") {
                if (file_exists("views/backend.view.php")) {
                    $this->template = "backend";
                } else {
                    // logs
                    die("Le template n'existe pas");
                }
            } else{
                if (file_exists("views/frontend.view.php")) {
                    $this->template = "frontend";
                } else {
                    // logs

                    die("Le template n'existe pas");
                }
            }
        } else {
            $this->template = "connection";
        }
    }

//    public function setTemplateBo($template) {
//        if (file_exists("views/".$template.".view.php")) {
//            $this->templateBack = $template;
//        } else {
//            // logs
//
//            die("Le template n'existe pas");
//        }
//    }

    public function assign($key, $value) {
        $this->data[$key] = $value;
    }

    public function includeModal($modal, $config) {
        if (file_exists("views/modals/".$modal.".mod.php")) {
            include "views/modals/".$modal.".mod.php";
        } else {
            // logs
            die("Le modal n'existe pas");
        }
    }

    public function __destruct() {
        global $msgError;

        extract($this->data);
        include "views/".$this->template.".view.php";
    }


}