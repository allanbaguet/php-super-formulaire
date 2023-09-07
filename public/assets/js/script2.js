// REGEX
let userNameRegex = /^[0-9a-zA-Z]+$/img;
let emailRegex = /^((?!\.)[\w-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/img;

// variables input
let inputUserValue = document.getElementById('user-name')
let usernameError = document.getElementById('username-error')

// classes CSS
let notError = document.getElementsByClassName('border-green');
let Error = document.getElementsByClassName('border-red');

// Fonction validation userName
const validateUsername = () => {
    usernameError.classList.add('d-none')
    inputUserValue.classList.remove('border-danger', 'border-success', 'border-3')

    if (inputUserValue.value == ''){
        return
    }

    let regexInstance = new RegExp(userNameRegex)
    let result = regexInstance.test(inputUserValue.value)
    
    if (result == false) {
        inputUserValue.classList.add('border-danger', 'border-3')
        usernameError.classList.remove('d-none')
    } else {
        inputUserValue.classList.add('border-success', 'border-3')
        usernameError.classList.add('d-none')
    }
}

let mailError = document.getElementById('email-error')
let inputEmail = document.getElementById('email')


// fonction validate mail
const validateMail = () => {

    mailError.classList.add('d-none')
    inputEmail.classList.remove('border-danger', 'border-success', 'border-3')

    if(inputEmail.value == ''){
        return
    }

    let regexInstance1 = new RegExp(emailRegex)
    let result1 = regexInstance1.test(inputEmail.value)
    if(result1 == false){
        inputEmail.classList.add('border-danger', 'border-3')
        mailError.classList.remove('d-none')
    }  else {
        inputEmail.classList.add('border-success', 'border-3')
        mailError.classList.add('d-none')
    }
}
// variable input password

let imputPassword = document.getElementById('password')
let imputPasswordVerif = document.getElementById('confirm-password')
let passwordError = document.getElementById('password-error')

// fonction validate password

const validatePassword = () => {
    passwordError.classList.add('d-none')
    imputPassword.classList.remove('border-danger', 'border-success', 'border-3')

    if(imputPassword.value == ''){
        return
    }

    if(imputPassword.value == imputPasswordVerif.value){
        imputPassword.classList.add('border-success', 'border-3')
        passwordError.classList.add('d-none')
    } else {
        imputPassword.classList.remove('border-danger', 'border-3')
        passwordError.classList.remove('d-none')
    }

}

const validatePasswordVerif = () => {
    passwordError.classList.add('d-none')
    imputPasswordVerif.classList.remove('border-danger', 'border-success', 'border-3')
    
    if(imputPasswordVerif.value == ''){
        return
    }

    if(imputPassword.value != imputPasswordVerif.value){
        imputPasswordVerif.classList.add('border-danger', 'border-3')
        passwordError.classList.remove('d-none')
    }  else {
        imputPasswordVerif.classList.add('border-success', 'border-3')
        passwordError.classList.add('d-none')
        
        imputPassword.classList.add('border-success', 'border-3')
        passwordError.classList.remove('d-none')
        }
    
}


// exo 3

// regex 
let passwordRegexUltraWeak = /^[a-z]+$/
let passwordRegexWeak = /^[a-z]+[A-Z]{1,}$/
let passwordRegexAvg = /^[a-z]{8,}[A-Z]{1,}[0-9]+$/
let passwordHeavy = /^[a-z]{8,}[A-Z]{1}[0-9]+[âêîôûäëïöüùéèàç\-_!?\.,:&#]+$/

// declaration variables
let weakPassword = document.getElementById('weakPassword')
let avgPassword = document.getElementById('avgPassword')
let heavyPassword = document.getElementById('heavyPassword')

// Fonction password security

const passwordLevel = () => {

    
    if(imputPassword.value == ''){
        return
    }
    let regexUltraWeakPassword = passwordRegexUltraWeak.test(imputPassword.value)
    
    if (regexUltraWeakPassword === true){
        weakPassword.classList.remove('d-none')
        avgPassword.classList.add('d-none')
        heavyPassword.classList.add('d-none')
    }

    let regexWeakPassword = passwordRegexWeak.test(imputPassword.value)
    
    if(regexWeakPassword === true){
        weakPassword.classList.remove('d-none')
        avgPassword.classList.add('d-none')
        heavyPassword.classList.add('d-none')
    }

    let regexAvgPassword = passwordRegexAvg.test(imputPassword.value)

    if(regexAvgPassword === true){
        weakPassword.classList.add('d-none')
        avgPassword.classList.remove('d-none')
        heavyPassword.classList.add('d-none')
    }

    let regexheavyPassword = passwordHeavy.test(imputPassword.value)

    if(regexheavyPassword === true){
        weakPassword.classList.add('d-none')
        avgPassword.classList.add('d-none')
        heavyPassword.classList.remove('d-none')
    }
}





//listener
inputUserValue.addEventListener('keyup', validateUsername)
inputEmail.addEventListener('keyup', validateMail)
imputPassword.addEventListener('keyup', validatePassword)
imputPasswordVerif.addEventListener('keyup', validatePasswordVerif)
imputPassword.addEventListener('keyup', passwordLevel)