     document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('myForm');
        const fnameInput = document.getElementById('fname');
        const lnameInput = document.getElementById('lname');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const passwordInput = document.getElementById('password');
        const rpassInput = document.getElementById('rpass');

        fnameInput.addEventListener('input', validateFirstName);
        lnameInput.addEventListener('input', validateLastName);
        emailInput.addEventListener('input', validateEmail);
        phoneInput.addEventListener('input', validatePhone);
        passwordInput.addEventListener('input', validatePassword);
        rpassInput.addEventListener('input', validateRepeatPassword);

        function validateFirstName() {
            if(fnameInput.value.trim().length < 3 ){
                fnameInput.style.backgroundColor = '#f253537a';
                fnameInput.style.color = 'red';
                document.querySelector('.ferror').innerText = 'the first name is too short';
            }else if(/[^a-zA-Z]/.test(fnameInput.value.trim()) === true){
                fnameInput.style.backgroundColor = '#f253537a';
                fnameInput.style.color = 'red';
                document.querySelector('.ferror').innerText = 'the first name must only contain letters';
            }
            else {
                fnameInput.style.backgroundColor = '#2db72d1c';
                fnameInput.style.color = 'var(--main)';
                document.querySelector('.ferror').innerText = '';
            }
        }

        function validateLastName() {

        }

        function validateEmail() {
            // Validation logic for email
        }

        function validatePhone() {
            // Validation logic for phone number
        }

        function validatePassword() {
            // Validation logic for password
        }

        function validateRepeatPassword() {
            // Validation logic for repeated password
        }

        function validateForm() {
            // Form submission validation logic here
        }
    });
    
    // const form = document.querySelector('.signupForm');
    // Array.from(form.elements).forEach(element => {
    //     element.addEventListener('input',function(){
    //          var inputValue = element.value.trim();

    //          const pass = document.querySelector('.pass');
    //          const rpass = document.querySelector('.rpass');

    //         if (inputValue.length === 0 || inputValue.length < 3) {
    //             element.style.backgroundColor = '#f253537a';
    //             element.style.color = 'red';
    //         } 
    //         else {
    //             element.style.backgroundColor = '#2db72d1c';
    //             element.style.color = 'var(--main)';
    //         }
    //     })
    // });
 
