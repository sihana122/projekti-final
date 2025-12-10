
let navbar = document.querySelector('navbar');

document.querySelector('@menu-btn').onclicl = () =>{
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');
}
let searchForm = document.querySelection('.search-form');

document.quertSelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('active');
    navbar.classList.remove('active');
    cartItem.classList.remove('active');
}
let cartItem = document.querySelector('.cart-items-container');

document.querySelector('#cart-btn').onclicl = () =>{
    cartItem.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
}
window.onscroll = () =>{
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');


}

function validateLoginForm(event) {
    const emailInput = document.querySelector('.login-form input[type="email"]');
    const passwordInput = document.querySelector('.login-form input[type="password"]');

    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();
    
    let hasError = false;

    clearErrors();

    if (email === "") {
        displayError(emailInput, "Adresa e Email-it kërkohet.");
        hasError = true;
    } else if (!isValidEmail(email)) {
        displayError(emailInput, "Ju lutemi shkruani një format email-i të vlefshëm.");
        hasError = true;
    }

    if (password === "") {
        displayError(passwordInput, "Fjalëkalimi kërkohet.");
        hasError = true;
    } else if (password.length < 6) {
        displayError(passwordInput, "Fjalëkalimi duhet të jetë të paktën 6 karaktere.");
        hasError = true;
    }

    if (hasError) {
        event.preventDefault(); 
        return false;
    }

    alert("Validimi në anën e klientit u krye me sukses. Tani dërgohet te serveri.");
}

function displayError(inputElement, message) {
    const errorElement = document.createElement('p');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    
    inputElement.classList.add('input-error');

    inputElement.parentNode.insertBefore(errorElement, inputElement.nextSibling);
}

function clearErrors() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(el => el.remove());
    
    const inputErrors = document.querySelectorAll('.input-error');
    inputErrors.forEach(el => el.classList.remove('input-error'));
}

function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('.login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', validateLoginForm);
    }
});