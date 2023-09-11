<?php
//récupération constante regex (dans un autre fichier.php)
// require './public/regex.php';
require_once __DIR__ . '/../config/regex.php';
//récupération constante des pays et des languages
require_once __DIR__ . '/../config/array.php';
//variable array contenant les erreurs
$errors = [];
//variable pour la date du jour
$currentDate = date('Y-m-d'); // Format de date YYYY-MM-DD


if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // récupération et validation de l'email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL,); //nettoie la chaine de caractère de l'email
    if (empty($email)) {
        $errors['email'] = 'Veuillez obligatoirement entrer un email';
    } else {
        $isOk = filter_var($email, FILTER_VALIDATE_EMAIL); //renvoi l'email ou false
        if ($isOk === false) {
            $errors['email'] = 'l\'email n\'est pas bon';
        }
    }
    //récupération et validation du nom
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($lastname)) {
        $errors['lastname'] = 'Veuillez obligatoirement entrer un nom';
    } else {
        $isOk = filter_var($lastname, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/' . REGEX_LASTNAME . '/')));
        if ($isOk == false) {
            $errors['lastname'] = 'Le champs n\'est pas valide';
        }
    }
    //récupération et validation du code postal
    $zipCode = filter_input(INPUT_POST, 'zipCode', FILTER_SANITIZE_NUMBER_INT);
    if (empty($zipCode)) {
        $errors['zipCode'] = 'Veuillez entrer un code postal';
    } else {
        $isOk = filter_var($zipCode, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/' . REGEX_ZIPCODE . '/')));
        if ($isOk == false) {
            $errors['zipCode'] = 'Le code postal n\'est pas valide';
        }
    }
    //seconde méthode code postal si le required est retiré
    //if(!empty($zipCode)) {
    //$isOk filter_var($zipCode, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => REGEX_ZIPCODE)));
    //}
    //if ($isOk == false) {
    //$errors['zipCode'] = 'Le code postal n\'est pas valide';
    //}

    //récupération et validation du pays de naissance
    $birthCountry = filter_input(INPUT_POST, 'birthCountry', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($birthCountry)) {
        $errors['birthCountry'] = 'Veuillez obligatoirement entrer un pays de naissance';
    } else {
        if ((in_array($birthCountry, COUNTRIES)) == false) {
            $errors['birthCountry'] = 'Veuillez selectionner votre pays de naissance';
        }
    }
    //récupération et validation de la civilité
    $civility = filter_input(INPUT_POST, 'civility', FILTER_SANITIZE_NUMBER_INT);
    if (!empty($civility)) {
        if ($civility != 1 && $civility != 2) {
            $errors['civility'] = 'Problème avec la civilité';
        }
    } else {
    }
    //récupération et validation de l'URL
    $urlLinked = filter_input(INPUT_POST, 'urlLinked', FILTER_SANITIZE_SPECIAL_CHARS);
    if (isset($_POST['urlLinked'])) {
        $urlLinked = $_POST['urlLinked'];
    } else {
        $errors['urlLinked'] = 'Veuillez fournir une URL LinkedIn valide';
    }
    // Vérifier l'URL LinkedIn avec la regex
    if (!empty($urlLinked) && !preg_match(REGEX_URL, $urlLinked)) {
        $errors['urlLinked'] = 'L\'URL LinkedIn n\'est pas valide';
    }
    //seconde méthode si l'input est required
    // if (empty($urlLinked)) {
    //     $errors['urlLinked'] = 'Veuillez obligatoirement entrer votre URL LinkedIn';
    // } else { 
    //     $isOk = filter_var($urlLinked, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => REGEX_URL )));
    //     if ($isOk == false) {
    //         $errors['urlLinked'] = 'Le champs n\'est pas valide';
    //     }
    // } 
    //récupération et validation des langages web
    $languages = filter_input(INPUT_POST, 'languages', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY) ?? []; //permet de récuperer quand même un tableau vide si la valeur est vide
    foreach ($languages as $key => $value) {
        if ((array_key_exists($value, LANGUAGES)) == false) {
            $errors['languages'] = 'Veuillez sélectionner un language valide';
        }
    }
    // if ((in_array($langages, LANGAGES)) == false) {
    //     $errors['langages[]'] = 'Veuillez sélectionner un language valide';
    // }
    //récupération et validation de la date de naissance
    $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_NUMBER_INT);
    $birthday = $_POST["birthday"];
    if (empty($birthday)) {
        $errors['birthday'] = 'Veuillez obligatoirement entrer une date de naissance.';
    } elseif ($birthday >= $currentDate) {
        $errors['birthday'] = 'Veuillez entrer une date de naissance valide.';
    } else {
    }
    //récupération et validation de la text area 
    $experienceText = filter_input(INPUT_POST, 'experienceText', FILTER_SANITIZE_SPECIAL_CHARS);
    if (!empty($experienceText)) {
        if (strlen($experienceText < 500)) {
            $errors['experienceText'] = 'Le nombre de caractères a été dépassé';
        }
    }
    //récupération et validation du mot de passe
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $password2 = filter_input(INPUT_POST, 'password2', FILTER_DEFAULT);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if (empty($password) || (empty($password2))) { // l'opérateur || correspond à 'OU'
        $errors['password'] = 'Veuillez obligatoirement entrer un mot de passe et sa confirmation';
    } else {
        $isOk = filter_var($password, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/' . REGEX_PASSWORD . '/')));
        if ($isOk == false) {
            $errors['password'] = 'Mot de passe non valide (Veuillez respecter la structure ci-dessus)';
        } elseif ($password !== $password2) {
            $errors['password'] = 'Les mots de passe ne sont pas identiques';
        } else {
            //fonction permettant de hashé le mot de passe (il est encrypté, qui sera toujours un string de 60 caractères de long)
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        }
    }
    var_dump($hashedPassword);
    // récupération et validation de l'image de profil
    try {
        $formFile = $_FILES['profilPicture'];
        if (empty($formFile['name'])) {
            throw new Exception("Veuillez renseigner un fichier", 1);
        }
        if ($formFile['error'] != 0) {
            throw new Exception("Fichier non envoyé", 2);
        }
        if (!in_array($formFile['type'], VALID_EXTENSIONS)) {
            throw new Exception("Mauvaise extension de fichier", 3);
        }
        if ($formFile['size'] >= FILE_SIZE) {
            throw new Exception("Taille du fichier dépassé", 4);
        }
        $extension = pathinfo($formFile['name'], PATHINFO_EXTENSION);
        $newNameFile = uniqid('pp_') . '.' . $extension;
        $from = $formFile['tmp_name'];
        $to = './public/uploads/user/' . $newNameFile;
        move_uploaded_file($from, $to);
        
    } catch (\Throwable $th) {
        $errors['profilPicture'] = $th->getMessage();
    }

}

?>