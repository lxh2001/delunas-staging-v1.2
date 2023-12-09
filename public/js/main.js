// add box shadow on header upon page scroll
window.addEventListener("scroll", function () {
  let navbar = document.querySelector(".header");
  let scrollPosition = window.scrollY || document.documentElement.scrollTop;

  if (scrollPosition >= navbar.offsetTop) {
    navbar.classList.add("sticky");
  } else {
    navbar.classList.remove("sticky");
  }

  // Toggle the shadow class based on scroll position
  if (scrollPosition > 10) {
    navbar.classList.add("header-shadow");
  } else {
    navbar.classList.remove("header-shadow");
  }
});

// slick or slider functions on homepage
// hero slider
$(function () {
  $(".hero-slider").slick({
    autoplay: true,
    dots: true,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: "linear",
  });

  $('.services-row').slick({
    dots: true,
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
    

  $(".reviews-list").slick({
    dots: true,
    autoplay: true,
    infinite: true,
    speed: 1000,
    cssEase: "linear",
  });
});


// Function to toggle notifications
function toggleNotification() {
  var notificationDiv = document.getElementById("notificationBox");

  if (notificationDiv.style.display === "block") {
    notificationDiv.style.display = "none";
  } else {
    notificationDiv.style.display = "block";
  }
}

// homepage nav menu toggle
function toggleHomepageMenu() {
  var menu = document.getElementById('homepageMenu');
  var homepageNav = document.getElementsByClassName('homepage-header')[0];
  var iconMenu = document.getElementById('menuIcon');
  var iconClose = document.getElementById('closeIcon');

  if (menu.style.display === "flex") {
    menu.style.display = "none";
    iconMenu.style.display = "block";
    iconClose.style.display = "none";
    homepageNav.style.backgroundColor = "transparent";
  } else {
    menu.style.display = "flex";
    iconMenu.style.display = "none";
    iconClose.style.display = "block";
    homepageNav.style.backgroundColor = "#fff";
  }
}

// portal sidebar toggle
function toggleMobileMenu() {
  var sidebar = document.getElementsByClassName("sidebar")[0];
  var sidebarIconMenu = document.getElementsByClassName("icon-menu")[0];
  var sidebarIconClose = document.getElementsByClassName("icon-close")[0];
  var contentBody = document.getElementsByClassName("content-body")[0];
  var navHeader = document.getElementsByClassName("header")[0];

  if(sidebar.style.display === "flex") {
    sidebar.style.display = "none";
    sidebarIconMenu.style.display = "block";
    sidebarIconClose.style.display = "none";
    contentBody.classList.add('close-content-mbl-pdg');
    navHeader.classList.add('close-header-mbl-pdg');
    contentBody.classList.remove('open-content-mbl-pdg');
    navHeader.classList.remove('open-header-mbl-pdg');
    notificationDiv.style.display = "none";
  } else {
    sidebar.style.display = "flex";
    sidebarIconMenu.style.display = "none";
    sidebarIconClose.style.display = "block";
    contentBody.classList.remove('close-content-mbl-pdg');
    navHeader.classList.remove('close-header-mbl-pdg');
    contentBody.classList.add('open-content-mbl-pdg');
    navHeader.classList.add('open-header-mbl-pdg');
    notificationDiv.style.display = "none";
  }
}


// function for TinyMCE text editor
tinymce.init({
  selector: ".mytextarea",
});