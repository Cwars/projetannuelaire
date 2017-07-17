<?php
if( !empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['titleImage']) && !empty($_POST['description'])) {

    //Créer deux objets, news et image qui sera attaché à la news grâce à l'idParent
    $news = new News();
    $mediafile = new Mediafile();

    $title = trim($_POST['title']);
    $author = $username;
    $content = trim($_POST['content']);
    $type = trim($_POST['type']);

    $titleImage = trim($_POST['titleImage']);
    $description = trim($_POST['description']);

    $error = false;
    $listOfErrors = [];

    if (strlen($title) < 2) {
        //Le titre doit faire au moins 2 caractères
        $listOfErrors[] = "nbTitle";
        $error = true;
    }

    if ($news->populate(['title' => $title])){
        //Le titre est déja utilisé
        $listOfErrors[] = "titleUsed";
        $error = true;
    }

    if (strlen($content) < 2) {
        //Le contenu doit faire au moins 2 caractères
        $listOfErrors[] = "nbContent";
        $error = true;
    }

    if (strlen($titleImage) < 2) {
        //Le titre doit faire au moins 2 caractères
        $listOfErrors[] = "nbTitle";
        $error = true;
    }

    if ($error === false) {

        $fileType = ["png", "jpg", "jpeg", "gif","mp3","wav","mp4","mov"];
        $limitSize = 100000000;

        if(empty($_FILES['mediafile'])){
            $listOfErrors[]='NoMediafile';
            $error = true;
        }else if($_FILES['mediafile']["error"] > 0){

            $error = true;
            switch ($_FILES["mediafile"]["error"]) {
                case UPLOAD_ERR_INI_SIZE:
                $listOfErrors[]='NoMediafile';
                break;
                case UPLOAD_ERR_FORM_SIZE:
                $listOfErrors[]='NoMediafile';
                break;
                case UPLOAD_ERR_PARTIAL:
                $listOfErrors[]='NoMediafile';
                break;
                case UPLOAD_ERR_NO_FILE:
                $listOfErrors[]='NoMediafile';
                break;
                case UPLOAD_ERR_NO_TMP_DIR:
                $listOfErrors[]='NoMediafile';
                break;
                case UPLOAD_ERR_CANT_WRITE:
                $listOfErrors[]='NoMediafile';
                break;
                case UPLOAD_ERR_EXTENSION:
                $listOfErrors[]='NoMediafile';
                break;
                default:
                $listOfErrors[]='NoMediafile';
                break;
            }
        }else{
            $infoFile = pathinfo($_FILES["mediafile"]["name"]);

            if(!in_array( strtolower($infoFile["extension"]) , $fileType)){
                $listOfErrors[]="10";
                $error = true;
            }

            if($_FILES["mediafile"]["size"]>$limitSize){
                $listOfErrors[]="11";
                $error = true;
            }

            switch (strtolower($infoFile["extension"])){
                case "png":
                case "jpg":
                case "jpeg":
                case "gif":
                $typeImage = "image";
                break;
                case "mp3":
                case "wav":
                $typeImage = "musique";
                break;
                case "mp4":
                case "mov":
                $typeImage = "vidéo";
                break;
            }

        //Est ce que le dossier upload existe
            echo $_SERVER['DOCUMENT_ROOT'];
            $pathUpload =$_SERVER['DOCUMENT_ROOT'].DS."images".DS."upload";

            if( !file_exists($pathUpload) ){
                //Sinon le créer
                mkdir($pathUpload);
            }
            //Déplacer l'avatar dedans
            $nameFile = uniqid().".". strtolower($infoFile["extension"]);
            move_uploaded_file($_FILES["mediafile"]["tmp_name"], $pathUpload.DS.$nameFile);

            $news->setTitle($title);
            $news->setAuthor($author);
            $news->setContent($content);
            $news->setType($type);
            $news->setIsDeleted(0);

            $mediafile->setTitle($titleImage);
            $mediafile->setDescription($description);
            $mediafile->setIsDeleted(0);
            $mediafile->setPath($pathUpload.DS.$nameFile);
            $mediafile->setType($typeImage);
            $mediafile->setTitleParent($title);
            $mediafile->setTypeParent($type);

            $news->save();
            $mediafile->save();
        }
    }
}else{
    $listOfErrors[] = "7";
    $_SESSION["form_error"] = $listOfErrors;
    $_SESSION["form_post"] = $_POST;
}

echo "<div class=\"content-wrapper\">";
if( isset($_SESSION["form_error"]) ){
    foreach ($_SESSION["form_error"] as $error) {
        echo "<li>".$msgError[$error];
    }
}
unset($_SESSION["form_post"]);
unset($_SESSION["form_error"]);
echo "</div>";