<div class="content-wrapper">
<?php

if(isset($idDelete)){

    $idUp = $idDelete[0];

    $user=((new User())->populate(['id' => $idUp]));
    $user->setIsDeleted(1);
    $user->save();

    echo "L'utilisateur ".$user->getUsername()." a été supprimé";

}

?>
</div>
