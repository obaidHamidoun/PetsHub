const form = document.getElementById('signUpform');
const fnameInput = document.getElementById('fname');
const lnameInput = document.getElementById('lname');
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');
const passwordInput = document.getElementById('password');
const rpassInput = document.getElementById('rpass');

let passwordTimer;
let rpassTimer;

fnameInput.addEventListener('input', validateFirstName);
lnameInput.addEventListener('input', validateLastName);
emailInput.addEventListener('input', validateEmail);
phoneInput.addEventListener('input', validatePhone);

passwordInput.addEventListener('input', () => {
    validatePassword();
    startTimer(passwordInput, 'password');
});
rpassInput.addEventListener('input', () => {
    validateRepeatPassword();
    startTimer(rpassInput, 'rpass');
});

function throwerror(inputname, errname, text) {
    inputname.style.backgroundColor = '#f253537a';
    inputname.style.color = 'red';
    document.querySelector('.' + errname).innerText = text;
}

function valide(inputname, errdisppear) {
    inputname.style.backgroundColor = '#2db72d1c';
    inputname.style.color = 'var(--main)';
    document.querySelector('.' + errdisppear).innerText = '';
}

function validateFirstName() {
    if (fnameInput.value.trim().length === 0) {
        throwerror(fnameInput, 'ferror', 'First Name cannot be empty.');
    } else if (fnameInput.value.trim().length < 3) {
        throwerror(fnameInput, 'ferror', 'First Name is too short.');
    } else if (fnameInput.value.trim().length >= 15) {
        throwerror(fnameInput, 'ferror', 'First Name is too long.');
    } else if (/[^a-zA-Z]/.test(fnameInput.value.trim())) {
        throwerror(fnameInput, 'ferror', 'First Name must contain letters only.');
    } else {
        valide(fnameInput, 'ferror');
    }
}

function validateLastName() {
    if (lnameInput.value.trim().length === 0) {
        throwerror(lnameInput, 'lerror', 'Last Name cannot be empty.');
    } else if (lnameInput.value.trim().length < 3) {
        throwerror(lnameInput, 'lerror', 'Last Name is too short.');
    } else if (lnameInput.value.trim().length >= 20) {
        throwerror(lnameInput, 'lerror', 'Last Name is too long.');
    } else if (/[^a-zA-Z]/.test(lnameInput.value.trim())) {
        throwerror(lnameInput, 'lerror', 'Last Name must contain letters only.');
    } else {
        valide(lnameInput, 'lerror');
    }
}

function validateEmail() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const emailValue = emailInput.value.trim();

    if (emailInput.value.trim().length === 0) {
        throwerror(emailInput, 'Eerror', 'Email cannot be empty.');
    } if (emailInput.value.trim().length < 5) {
        throwerror(emailInput, 'Eerror', 'Email is too short.');
    } else if (!emailRegex.test(emailValue.toLowerCase())) {
        throwerror(emailInput, 'Eerror', 'Invalid email address.');
    } else {
        valide(emailInput, 'Eerror');
    }
}

function validatePhone() {
    const phoneRegex = /^\+?[\d]{10,}$/;
    if (phoneInput.value.trim().length === 0) {
        throwerror(phoneInput, 'pherror', 'Phone number cannot be empty.');
    } if (phoneInput.value.trim().length < 10) {
        throwerror(phoneInput, 'pherror', 'Phone number is too short.');
    } else if (!phoneRegex.test(phoneInput.value.trim())) {
        throwerror(phoneInput, 'pherror', 'Invalid phone number. Must contain only digits');
    } else if (phoneInput.value.trim().length > 15) {
        throwerror(phoneInput, 'pherror', 'Phone number is too long.');
    } else {
        valide(phoneInput, 'pherror');
    }
}

function validatePassword() {
    const passwordRegex = /^[a-zA-Z0-9@-_]+$/;
    if (passwordInput.value.trim().length === 0) {
        throwerror(passwordInput, 'perror', 'Password cannot be empty.');
    } else if (passwordInput.value.trim().length < 6) {
        throwerror(passwordInput, 'perror', 'Password is too short.');
    } else if (!passwordRegex.test(passwordInput.value.trim())) {
        throwerror(passwordInput, 'perror', 'Password must only contain letters, digits, and @, -, _.');
    } else {
        valide(passwordInput, 'perror');
    }
}

function validateRepeatPassword() {
    if (rpassInput.value.trim().length === 0) {
        throwerror(rpassInput, 'rerror', 'Repeat Password cannot be empty.');
    } else if (rpassInput.value.trim() !== passwordInput.value.trim()) {
        throwerror(rpassInput, 'rerror', 'Passwords do not match.');
    } else {
        valide(rpassInput, 'rerror');
    }
}

function startTimer(passwordField, fieldType) {
    if (fieldType === 'password') {
        clearTimeout(passwordTimer);
        passwordField.type = 'text';
        passwordTimer = setTimeout(() => {
            passwordField.type = 'password';
        }, 2000);
    } else if (fieldType === 'rpass') {
        clearTimeout(rpassTimer);
        passwordField.type = 'text';
        rpassTimer = setTimeout(() => {
            passwordField.type = 'password';
        }, 2000);
    }
}

function validateForm() {
    validateFirstName();
    validateLastName();
    validateEmail();
    validatePhone();
    validatePassword();
    validateRepeatPassword();

    const errorMessages = form.querySelectorAll('.error');
    let isValid = true;
    errorMessages.forEach(message => {
        if (message.textContent !== '') {
            isValid = false;
        }
    });

    return isValid;
}

form.addEventListener('submit', function (event) {
    event.preventDefault();

    if (validateForm()) {
        let fname = fnameInput.value;
        let lname = lnameInput.value;
        let email = emailInput.value;
        let phone = phoneInput.value;
        let password = passwordInput.value;

        let xml = new XMLHttpRequest();
        xml.open("POST", "../php/signUp.php", true);
        xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xml.onload = function () {
            if (xml.readyState === XMLHttpRequest.DONE) {
                if (xml.status === 200) {
                    if (xml.responseText.trim() === "true") {
                        setTimeout(function(){
                            document.querySelector('.signUpButton').innerHTML = 'Account Created Successfully';
                            document.querySelector('.signUpButton').style.backgroundColor = '#49f1a3';
                            document.querySelector('.signUpButton').style.color = '#32a46f';
                        }, 10);
                        window.location.href = '../html/home.html';
                        console.log(xml.responseText)

                    } else {
                        alert('user already exists');
                        console.log(xml.responseText)
                    }
                }
            }
        };

        let data = "fname=" + encodeURIComponent(fname) + 
                   "&lname=" + encodeURIComponent(lname) + 
                   "&email=" + encodeURIComponent(email) + 
                   "&phone=" + encodeURIComponent(phone) + 
                   "&password=" + encodeURIComponent(password);
        xml.send(data);(t)
    }
});

