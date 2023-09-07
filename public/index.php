<?php
//récupération constante regex (dans un autre fichier.php)
require './regex.php';
//récupération constante des pays et des languages
require './array.php';
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
    $allowedType = array('png', 'jpg', 'jpeg');
    // check la taille du fichier
    if ($_FILES['profilPicture']['size'] > 5000000) {
        $errors['profilPicture'] = 'Le fichier est trop gros';
    }
    //check du type du fichier

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Mon super formulaire</title>
</head>

<body>
    <h1 class="title text-center text-white fw-bold">Mon super formulaire</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col d-flex justify-content-center border border-5 rounded-end-circle">
                <form action="" method="POST" novalidate>
                    <fieldset>
                        <p class="text-white fw-bold py-1">* (Champs obligatoire)</p>
                        <!-- Partie adresse mail -->
                        <div class="form-group text-white fw-bold">
                            <label for="email" class="form-label mt-4">Adresse mail * :</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Entrez votre mail" value="<?php $email['email'] ?? '' ?>" pattern="<?= REGEX_EMAIL ?>" required>
                            <div id="emailHelp" class="form-text error d-none text-danger">Cet email n'est pas valide</div>
                            <p class="error"> <?= $errors['email'] ?? '' ?> </p>
                        </div>
                        <!-- Partie mot de passe -->
                        <div class="form-group text-white fw-bold">
                            <label for="password" class="form-label">Mot de passe * : </label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php $password['password'] ?? '' ?>" pattern="<?= REGEX_PASSWORD ?>" placeholder="Entrez votre mot de passe" required>
                            <p class="fw-lighter fst-italic">8 Caractères minimum / 1 majuscule minimum </p>
                            <p class="fw-lighter fst-italic"> 1 minuscule minimum / 1 chiffre minimum</p>
                        </div>
                        <div class="form-group text-white fw-bold">
                            <label for="password" class="form-label">Confirmer le mot de passe * : </label>
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirmation du mot de passe" required>
                            <div id="passwordCheck" class="form-text error d-none text-danger">Le mot de passe n'est pas identique</div>
                            <p class="error"> <?= $errors['password'] ?? '' ?> </p>
                        </div>
                        <!-- Partie civilité -->
                        <fieldset class="form-group text-white fw-bold">
                            <label for="civility" class="form-label mt-4">Choisissez votre civilité :</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="civility" id="radio1" value="1">
                                <label class="form-check-label" for="radio1">
                                    Monsieur
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="civility" id="radio2" value="2">
                                <label class="form-check-label" for="radio2">
                                    Madame
                                </label>
                            </div>
                            <p class="error"> <?= $errors['civility'] ?? '' ?> </p>
                        </fieldset>
                        <!-- Partie nom -->
                        <div class="form-group text-white fw-bold">
                            <label for="lastname" class="form-label mt-4">Votre nom * :</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" value="" placeholder="Entrez votre nom " autocomplete="family-name" pattern="<?= REGEX_LASTNAME ?>" required>
                            <div id="lastnameHelp" class="form-text error d-none text-danger">Ce champ n'est pas valide</div>
                            <p class="error"> <?= $errors['lastname'] ?? '' ?> </p>
                        </div>
                        <!-- Partie date de naissance -->
                        <div class="form-group text-white fw-bold">
                            <label for="birthday" class="form-label mt-4">Votre date de naissance *:</label>
                            <input type="date" class="form-control" name="birthday" id="birthday" max="<?= $currentDate ?>" required>
                            <p class="error"> <?= $errors['birthday'] ?? '' ?> </p>
                        </div>
                        <!-- Partie pays de naissance -->
                        <div class="form-group">
                            <label for="birthCountry" class="form-label mt-4 text-white fw-bold">Pays de naissance *:</label>
                            <select class="form-control" name="birthCountry" id="birthCountry">
                                <option selected disabled>Choisissez un pays de naissance</option>
                                <?php
                                foreach (COUNTRIES as $key => $birthCountry) { ?>
                                    <option><?= $birthCountry ?> </option>
                                <?php }
                                ?>
                            </select>
                            <p class="error"> <?= $errors['birthCountry'] ?? '' ?> </p>
                        </div>
                        <!-- Partie code postal -->
                        <div class="form-group text-white fw-bold">
                            <label for="zipCode" class="form-label mt-4">Code postal * :</label>
                            <input type="text" inputmode="numeric" class="form-control" name="zipCode" id="zipCode" placeholder="80100" pattern="<?= REGEX_ZIPCODE ?>" required>
                            <p class="error"> <?= $errors['zipCode'] ?? '' ?> </p>
                        </div>
                        <!-- Partie image de profil -->
                        <div class="form-group text-white fw-bold">
                            <label for="profilPicture" class="form-label mt-4">Image de profil :</label>
                            <input type="hidden" name="MAX_FILES_SIZE" value="5000000">
                            <!-- permet de mettre une taille maximale sur le fichier, en octets (ici 5mo)-->
                            <input class="form-control" type="file" name="profilPicture" id="profilPicture" accept="image/png, image/jpeg, image/jpg">
                            <p class="error"> <?= $errors['profilPicture'] ?> </p>
                        </div>
                        <!-- Partie URL LinkedIn -->
                        <div class="form-group text-white fw-bold">
                            <label for="urlLinked" class="form-label mt-4">Indiquez l'URL de votre compte LinkedIn :</label>
                            <input class="form-control" type="url" name="urlLinked" id="urlLinked" placeholder="https://www.linkedin.com/in/..." pattern="<?= REGEX_URL ?>">
                            <p class="error"> <?= $errors['urlLinked'] ?? '' ?></p>
                        </div>
                        <!-- Partie langage web -->
                        <label for="language" class="form-label mt-4 text-white fw-bold">Quels langages web connaissez-vous ?</label>
                        <div class="form-group d-flex text-white fw-bold">
                            <?php
                            foreach (LANGUAGES as $key => $languages) {
                                $id = $key + 1;
                            ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $languages ?>" id="<?= $id ?>" name="languages[]">
                                    <label class="form-check-label" for="<?= $id ?>">
                                        <?= $languages ?>
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <p class="error"> <?= $errors['languages'] ?? '' ?></p>
                        <!-- Partie expérience -->
                        <div class="form-group text-white fw-bold">
                            <label for="experienceText" class="form-label mt-4">Racontez votre expérience :</label>
                            <textarea class="form-control" id="experienceText" name="experienceText" maxlength="500" placeholder="Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir. (500 caractères max)"></textarea>
                            <p class="error"> <?= $errors['experienceText'] ?? '' ?></p>
                        </div>
                        <!-- Partie bouton d'envoi -->
                        <div class="d-flex justify-content-center p-5" id="button">
                            <button type="submit" class="btn btn-light btn-lg">Envoi du formulaire</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
        const regexLastname = <?= REGEX_LASTNAME ?>
        const regexMail = <?= REGEX_EMAIL ?>
        const regexZipcode = <?= REGEX_ZIPCODE ?>
        const regexPassword = <?= REGEX_PASSWORD ?>
    </script>
    <script defer src="./assets/js/script.js"></script>
</body>