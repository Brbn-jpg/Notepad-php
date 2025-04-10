document.addEventListener("DOMContentLoaded", function () {
  const btnMobileNav = document.querySelector(".btn-mobile-nav");
  const nav = document.querySelector("nav");
  const openIcon = btnMobileNav.querySelector('ion-icon[name="menu-outline"]');
  const closeIcon = btnMobileNav.querySelector(
    'ion-icon[name="close-outline"]'
  );
  const loginRegisterLinks = nav.querySelector(".login");

  if (btnMobileNav && nav) {
    btnMobileNav.addEventListener("click", function () {
      // Jeśli nawigacja jest w trybie mobilnym
      if (nav.classList.contains("mobile-nav")) {
        // Przywróć nawigację do trybu głównego
        nav.classList.remove("mobile-nav");
        openIcon.style.display = "block"; // Pokaż ikonę menu
        closeIcon.style.display = "none"; // Ukryj ikonę zamknięcia
        // Ukryj linki "Zaloguj" i "Zarejestruj" po zamknięciu menu
        loginRegisterLinks.classList.add("hidden");
      } else {
        // W przeciwnym razie ustaw nawigację na tryb mobilny
        nav.classList.add("mobile-nav");
        console.log(1);
        openIcon.style.display = "none"; // Ukryj ikonę menu
        console.log(2);
        closeIcon.style.display = "block"; // Pokaż ikonę zamknięcia
        console.log(3);
        // Pokaż linki "Zaloguj" i "Zarejestruj" po otwarciu menu
        console.log(4);
        nav.classList.add("active"); // Aktywuj widoczność linków
      }
      loginRegisterLinks.classList.remove("hidden");
    });
  } else {
    console.log("Nie znaleziono przycisku lub nawigacji");
  }
});
