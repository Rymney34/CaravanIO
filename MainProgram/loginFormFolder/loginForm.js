
var img = document.getElementById('img');

// links to caravan images
var slides = ['https://images.unsplash.com/photo-1527542902003-a675625fb1eb?q=80&w=2752&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D','https://images.unsplash.com/photo-1530375323520-248ebdaa967f?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'https://images.unsplash.com/photo-1597327190279-43b91807c7a5?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'https://images.unsplash.com/photo-1563567801003-b112e3fcd367?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', ];

var Start=0;

// slider fucntion to slide caravan images
function slider(){
  if(Start<slides.length){
    Start=Start+1;
  }
  else{
    Start=1;
  }
  console.log(img);
  img.innerHTML = "<img src="+slides[Start-1]+">";

}
setInterval(slider,5000);
slider();


const username = document.querySelector('.form-input-username');
const password = document.querySelector('.form-input-password');

// function for validation of username and password
function validateLoginForm(username, password) {
  if (username.value === '' || password.value === '') {
    alert("Empty Username or Password");

  }
}

// when button pressed it should check if username and password not empty
const button1 = document.querySelector('.button-1');
button1.addEventListener('click', (e) => {
  validateLoginForm(username, password);
})

const icon = document.querySelectorAll('.togglePassword');

// event listner on click that shows password
for(let i = 0; i < icon.length; i++) {
  icon[0].addEventListener('click', e => {
    
      if(password.type === "password") {
          password.type = "text";
          icon[0].classList.add("fa-eye-slash");
          icon[0].classList.remove("fa-eye");
        } else {
          password.type = "password";
          icon[0].classList.add("fa-eye");
          icon[0].classList.remove("fa-eye-slash");
        }
  }
)}




