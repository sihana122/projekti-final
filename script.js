let navbar = document.querySelector('.navbar');
let searchForm = document.querySelector('.search-form');
let cartItem = document.querySelector('.cart-items-container');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');
}

document.querySelector('#search-btn').onclick = () =>{
    searchForm.classList.toggle('active');
    navbar.classList.remove('active');
    cartItem.classList.remove('active');
}

document.querySelector('#cart-btn').onclick = () =>{
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
    event.preventDefault();
    
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
        return false;
    }

    localStorage.setItem('userEmail', email);
    localStorage.setItem('isLoggedIn', 'true');
    
    alert("U kyçët me sukses!");
    window.location.href = '#home';
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
