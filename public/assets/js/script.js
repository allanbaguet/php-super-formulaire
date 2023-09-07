// variables
let lastnameElement = document.querySelector('#lastname')
let lastnameHelp = document.querySelector('#lastnameHelp')
let emailElement = document.querySelector('#email');
let emailHelp = document.querySelector('#emailHelp');
let password1 = document.querySelector('#password');
let password2 = document.querySelector('#password2');
let passwordCheck = document.querySelector('#passwordCheck');


// liste des regex
// console.log(regexMail)
const regexLastname = /^[a-zA-ZÀ-ÖØ-öø-ÿ- ]{1,30}$/;
const regexMail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,5}$/;
const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;



// constante pour lastname
const checkLastname = () => {
    lastnameElement.classList.remove('border-danger', 'border-success', 'border-3')
    // permet de remove les class ajouté à bootstrap au moment de l'input 
    lastnameHelp.classList.add('d-none');
    // ajout de la classe d-none pour enlevé le message 

    if (lastnameElement.value== '') {
        return
    }
// permet de réinitialisé le champ si il est vide, return sert à stoppé la boucle si rien n'est écrit

    // refait une nouvelle instance à chaque input (évite le true/false/true/false ...)
    let isValid = regexLastname.test(lastnameElement.value)

    if (isValid == false) {
        lastnameElement.classList.add('border-danger', 'border-3')
        lastnameHelp.classList.remove('d-none');
    } else {
        lastnameElement.classList.add('border-success', 'border-3')
        lastnameHelp.classList.add('d-none');
    }
}


// constante pour l'email
const checkEmail = () => {
    emailElement.classList.remove('border-danger', 'border-success', 'border-3')
    emailHelp.classList.add('d-none');

    if (emailElement.value== '') {
        return
    }

    let regexInstance = new RegExp(regexMail)
    let isValid = regexInstance.test(emailElement.value)

    if (isValid == false) {
        emailElement.classList.add('border-danger', 'border-3')
        emailHelp.classList.remove('d-none');
    } else {
        emailElement.classList.add('border-success', 'border-3')
        emailHelp.classList.add('d-none');
    }
}


// constant pour les mots de passe
const validPassword = () => {
    password2.classList.remove('border-danger', 'border-success', 'border-3')
    password1.classList.remove('border-danger', 'border-success', 'border-3')
    passwordCheck.classList.add('d-none');

    if (password1.value == '' && password2.value == '') {
        return
    }
    let regexInstance = new RegExp(regexPassword)
    let isPasswordValid = regexInstance.test(password1.value)

    if (password1.value != password2.value) {
        password2.classList.add('border-danger', 'border-3')
        passwordCheck.classList.remove('d-none');
    } else {
        password2.classList.add('border-success', 'border-3')
        password1.classList.add('border-success', 'border-3')
        passwordCheck.classList.add('d-none');
    }

}

// const validPassword = () => {
//     password2.classList.remove('border-danger', 'border-success', 'border-3');
//     password1.classList.remove('border-danger', 'border-success', 'border-3');
//     passwordCheck.classList.add('d-none');

//     if (password1.value === '' && password2.value === '') {
//         return;
//     }

//     const regexInstance = new RegExp(regexPassword);
//     const isPasswordValid = regexInstance.test(password1.value);
//     const doPasswordsMatch = password1.value === password2.value;

//     if (!isPasswordValid) {
//         password1.classList.add('border-danger', 'border-3');
//     } else {
//         password1.classList.add('border-success', 'border-3');
//     }

//     if (!doPasswordsMatch) {
//         password2.classList.add('border-danger', 'border-3');
//         passwordCheck.classList.remove('d-none');
//     } else {
//         password2.classList.add('border-success', 'border-3');
//         passwordCheck.classList.add('d-none');
//     }
// };

// écouteur d'évènements à l'appui de la touche du clavier
lastnameElement.addEventListener('keyup', checkLastname);
emailElement.addEventListener('keyup', checkEmail);
password1.addEventListener('keyup', validPassword)
password2.addEventListener('keyup', validPassword)


