<?php
include ('assets/PHPMailer/PHPMailerAutoload.php');

if(!empty($_POST['username']) && !empty($_POST['firstname'])  && !empty($_POST['lastname']) && isset($_POST["email"]) && isset($_POST["pwd"]) && isset($_POST["pwd2"])) {
    $user = new User();
    $username = htmlentities($_POST['username']);
    $status = "User";
    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $email = htmlentities($_POST['email']);
    $pwd = $_POST['pwd'];
    $pwd2 = $_POST['pwd2'];
    $cgu = $_POST['cgu'];
    $newsletter = $_POST['newsletter'];
    $now = date("Y-m-d H:i:s");

    $error = false;
    $listOfErrors = [];

    if (!$user->populate(['username' => $username])) {
        if (!$user->populate(['email' => $email])) {

            if ($cgu != 1){
                //CGU coché
                $listOfErrors[] = "cgu";
                $error = true;
            }

            //Le nom d'utilisateur est déjà utilisé
            if (strlen($username) < 2) {
                //Le nom d'utilisateur doit faire au moins 2 caractères
                $listOfErrors[] = "nbUsername";
                $error = true;
            }

            if ($user->populate(['username' => $username])) {
                //Le nom d'utilisateur est déja utilisé
                $listOfErrors[] = "usernameUsed";
                $error = true;
            }

            //Vérifier le nom
            if (strlen($lastname) == 1) {
                //Le nom doit faire au moins 2 caractères
                $listOfErrors[] = "nbLastname";
                $error = true;
            }

            //Vérifier le prénom
            if (strlen($firstname) == 1) {
                //Le prénom doit faire au moins 2 caractères
                $listOfErrors[] = "nbFirstname";
                $error = true;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Email incorrect
                $listOfErrors[] = "errorEmail";
                $error = true;
            }

            if (strlen($pwd) < 8 || strlen($pwd) > 12) {
                //Le mot de passe doit faire entre 8 et 12 caractères
                $listOfErrors[] = "nbPwd";
                $error = true;
            }

            if ($pwd != $pwd2) {
                //Le mot de passe de confirmation ne correspond pas
                $listOfErrors[] = "pw1/pw2";
                $error = true;
            }

            if($newsletter == 1){
                $sub = new Subscribers();
                $sub->setUsernameSub($username);

                $sub->save();
            }

            if ($error === false) {
                $user->setUsername($username);
                $user->setStatus($status);
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setEmail($email);
                $user->setPwd($pwd);
                $user->setDateInserted($now);
                $user->setDateUpdated($now);
                $user->setIsDeleted(1);

                $user->save();

                //Envoie de mail

                $mail = new PHPMailer();
                $mail ->IsSmtp();
                $mail ->SMTPDebug = 0;
                $mail ->SMTPAuth = true;
                $mail ->SMTPSecure = 'ssl';
                $mail ->Host = "smtp.gmail.com";
                $mail ->Port = 465; // or 587
                $mail ->IsHTML(true);

                // Authentification
                $mail->Username = "esgi.aire@gmail.com";
                $mail->Password = "3iw1Esgi%75013";

                // Expéditeur
                $mail->SetFrom("esgi.aire@gmail.com", "esgi-aire");
                // Destinataire
                $mail->AddAddress($email, $firstname);
                // Objet
                $mail->Subject = "Confirmation par mail";
                // Votre message
                $mail->MsgHTML('Hello '.$firstname.
                    '<br>
                You can activate your account with this link ! =>'.PATH_RELATIVE.'userConfirmation/'.$username.
                    '<br>
                Best Regards :'
                );

                // Envoi du mail avec gestion des erreurs
                if(!$mail->Send()) {
                    echo 'Erreur : ' . $mail->ErrorInfo;
                } else {
                    echo 'Message envoyé !';
                }

                $listOfErrors[] = "added";
                $succed = true;
            } else {
                $_SESSION["form_post"] = $_POST;
                $error = true;
            }
        } else{
            $listOfErrors[] = "emailUsed";
            $error = true;
        }
    } else {
        $listOfErrors[] = "usernameUsed";
        $error = true;
    }
}else{
    $listOfErrors[] = "allRequired";
    $error = true;
    $_SESSION["form_post"] = $_POST;
}
if ($error == true) {
    $_SESSION['form_error'] = $listOfErrors;
    header("Location: ".PATH_RELATIVE."register");
}
if ($succed == true)
{
    unset($_SESSION['form_post']);
    header("Location: ".PATH_RELATIVE."home");
}

// Supprimé ca en dessous, stocker valeur du formulaire en session  => une foi de retour sur la page,