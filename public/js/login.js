const signupLink = document.getElementById("signupLink");
const loginLink = document.getElementById("loginLink");
const loginWrapper = document.querySelector(".login-r");
const signupSection = document.querySelector(".signup-section");

// Add click event listener to the "Sign up for free" link
signupLink.addEventListener("click", function (e) {
  e.preventDefault();
  loginWrapper.style.display = "none";
  signupSection.style.display = "flex";
});

// Add click event listener to the "Already have an account?" link
loginLink.addEventListener("click", function (e) {
  e.preventDefault();
  loginWrapper.style.display = "flex";
  signupSection.style.display = "none";
});

// removing disabled attribute to Create Account btn when ToC is checked
const termsCheckbox = document.getElementById("termsConditions");
const createAccountButton = document.getElementById("createAccountButton");

termsCheckbox.addEventListener("change", function () {
  createAccountButton.disabled = !termsCheckbox.checked;
});
