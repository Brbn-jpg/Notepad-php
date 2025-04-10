document.addEventListener("DOMContentLoaded", function () {
  const btnMobileNav = document.querySelector(".btn-mobile-nav");
  const nav = document.querySelector("nav");
  const openIcon = btnMobileNav.querySelector(".menu");
  const closeIcon = btnMobileNav.querySelector(".close");
  const loginRegisterLinks = nav.querySelector(".login");

  if (btnMobileNav && nav) {
    btnMobileNav.addEventListener("click", function () {
      if (nav.classList.contains("mobile-nav")) {
        nav.classList.remove("mobile-nav");
        openIcon.style.display = "block";
        closeIcon.style.display = "none";
        loginRegisterLinks.classList.add("hidden");
      } else {
        nav.classList.add("mobile-nav");
        openIcon.style.display = "none";
        closeIcon.style.display = "block";
        nav.classList.add("active");
      }
      loginRegisterLinks.classList.remove("hidden");
    });
  } else {
    console.log("Nie znaleziono przycisku lub nawigacji");
  }
});
