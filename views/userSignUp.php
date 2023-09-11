<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/assets/css/style.css">
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
                            <input class="form-control" type="file" name="profilPicture" id="profilPicture" accept="image/png, image/jpeg, image/jpg">
                            <p class="error"> <?= $errors['profilPicture'] ?? '' ?> </p>
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