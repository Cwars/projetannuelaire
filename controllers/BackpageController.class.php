<?php

class BackpageController
{

    public function PageMenuAction($params) {
        $page = new Page();

        $type = "page";
        $search = ["id","title"];
        $res = $page->getObj($search,$params[0],NB_ITEM_BACK);

        if( !is_int($params[0]) || $params[0]>0 && $params[0]<=$res[1]){
            $v = new View("menuPage");
            $v->assign("search", $search);
            $v->assign("result", $res[0]);
            $v->assign("nbPage", $res[1]);
            $v->assign("type", $type);
        } else {
            $v = new View("page404");
        }
    }

    public function PageUpdateAction($params) {
        $v = new View("pageUpdate");

        $page=((new Page())->populate(['id' => $params[0]]));
        $id = $params[0];
        $title = $page->getTitle();
        $content = $page->getContent();

        if ($title == "Home"){
            $news = $page->getHasNews();
            $event = $page->getHasEvent();
            $v->assign("formUpdate", $page->getFormPageHomeUpdate($id,$content,$news,$event));
        } else {
            $v->assign("formUpdate", $page->getFormSimplePageUpdate($id,$content));
        }

    }
    public function PageActionUpdateAction($params) {
        $v = new View("pageActionUpdate");

        $page=((new Page())->populate(['id' => $params[0]]));

        $title = $page->getTitle();

        $v->assign("titleUpdate",$title);
        $v->assign("idUpdate",$params[0]);
    }

}