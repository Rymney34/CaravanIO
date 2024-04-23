// variables
const firstName = document.getElementById('first-name');
const surName = document.getElementById('last-name');
const userName = document.getElementById('User-name');
const email = document.getElementById('eemail');
let password = document.getElementById('Password-field');
const confirmPassword = document.getElementById('Conf-Password-field');

const modal = document.querySelector('.modal');
const button1 = document.getElementById('button1');
const passwordNode = document.querySelectorAll('.pass')


// set the button initially as disabled
button1.setAttribute('disabled', 'true');


// set field to the statament false and when it true button register will be enabled

let firstNameValid = false;
let surNameValid = false;
let userNameValid = false;
let emailValid = false;
let passwordValid = false;
let confirmPasswordValid = false;


// fucntion that validate inputs for  FirstName, Surname , Username
function validateInput(input, isValid) {
  if (input.value.trim() === '') {
    modal.classList.add('show');
    modal.innerHTML = 
    `
    <div class='valid-error'>Can't leave empty</div>
    `;
    isValid = false;
    console.log('someifff')
  } else {
    modal.classList.remove('show');
    modal.innerHTML = '';
    isValid = true;
  }
  return isValid;
}
// fucntion that validate Password
function validatePassword(password, isValid) {
 
  const passwordRegex =/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/;
  

    if (password.length<8) {
    
      modal.classList.add('show')
      modal.innerHTML =
      `
        <div class='valid-error'>Password must be at least 8 characters</div>
      `
          
  }
    else if(!passwordRegex.test(password.value)) {
    

      modal.classList.add('show')
      modal.innerHTML =
      `
        <div class='valid-error'>Password require one each of "a-z , A-Z, 0-9" </div>
      `
      isValid = false;
  }
  else{
    modal.classList.remove('show')
    modal.innerHTML = ` `
    isValid = true;
  }
  return isValid;
}
// fucntion that validate Email
function validateEmail(email, isValid) {
  
  if (!((email.value.indexOf('.') > 0) && (email.value.indexOf("@") > 0)) || (/[^a-zA-Z0-9.@_-]/.test(email.value))){

    modal.classList.add('show')
    modal.innerHTML =
    `
      <div class='valid-error'>The Email address is invalid</div>
    `
    isValid = false;
}

  else{
    modal.classList.remove('show')
    modal.innerHTML = ` `
    isValid = true;
  }
  return isValid;
}
// fucntion that Confirm the password
function validateConfirmPassword(confirmPassword, isValid) {

    validatePassword(password.value)
  
  if (confirmPassword.value === '') {
    modal.classList.add('show')
    modal.innerHTML =
    `
      <div class='valid-error'>You must Confirm Password</div>
    `
    isValid = false;
  }
    else if (password.value !== confirmPassword.value) {
    modal.classList.add('show')
    modal.innerHTML =
    `
      <div class='valid-error'>Password did not match</div>
    `
    isValid = false;
  }
  
  else{
    modal.classList.remove('show')
    modal.innerHTML = ` `
    isValid = true;
  }
  return isValid;
  
}
// function that responsible for enable button when all the  inputs valid/true
function updateButtonVisibility() {
  if (
    firstNameValid &&
    surNameValid &&
    userNameValid &&
    emailValid &&
    passwordValid &&
    confirmPasswordValid
  ) {

    button1.removeAttribute('disabled');
    
  } else {
  
    button1.setAttribute('disabled', 'true');
    
  }
}

// event listeners for each input fields
password.addEventListener('input', () => {
  passwordValid = validatePassword(password, passwordValid);
  updateButtonVisibility();
});

email.addEventListener('input', () => {
  emailValid = validateEmail(email, emailValid);
  updateButtonVisibility();
});

confirmPassword.addEventListener('input', () => {
  confirmPasswordValid = validateConfirmPassword(confirmPassword, confirmPasswordValid);
  updateButtonVisibility();
});

firstName.addEventListener('input', () => {
  firstNameValid = validateInput(firstName, firstNameValid);
  updateButtonVisibility();
});

surName.addEventListener('input', () => {
  surNameValid = validateInput(surName, surNameValid);
  updateButtonVisibility();
});

userName.addEventListener('input', () => {
  userNameValid = validateInput(userName, userNameValid);
  updateButtonVisibility();
});

const icon = document.querySelectorAll('.togglePassword');

// for loop  and evenlistener that helps to show the eye icon on password
for(let i = 0; i < icon.length; i++) {
    icon[i].addEventListener('click', e => {
        const password = passwordNode[i]
        if(password.type === "password") {
            password.type = "text";
            icon[i].classList.add("fa-eye-slash");
            icon[i].classList.remove("fa-eye");
          } else {
            password.type = "password";
            icon[i].classList.add("fa-eye");
            icon[i].classList.remove("fa-eye-slash");
          }
    }
)}

