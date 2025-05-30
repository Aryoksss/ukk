// import "./bootstrap";
// import Alpine from "alpinejs";

// window.Alpine = Alpine;
// Alpine.start();

// // Animation for the landing page
// document.addEventListener("DOMContentLoaded", function () {
//     // Animate hero section elements
//     const animateHero = () => {
//         const heroElements = document.querySelectorAll(".hero-animate");
//         heroElements.forEach((el, index) => {
//             setTimeout(() => {
//                 el.classList.add("opacity-100", "translate-y-0");
//                 el.classList.remove("opacity-0", "translate-y-4");
//             }, 300 + index * 150);
//         });
//     };

//     // Handle dark mode toggle
//     const setupDarkMode = () => {
//         const darkModeToggle = document.getElementById("dark-mode-toggle");
//         if (darkModeToggle) {
//             darkModeToggle.addEventListener("click", () => {
//                 document.documentElement.classList.toggle("dark");
//                 localStorage.setItem(
//                     "darkMode",
//                     document.documentElement.classList.contains("dark")
//                         ? "enabled"
//                         : "disabled"
//                 );
//             });
//         }
//     };

//     // Check for saved dark mode preference
//     const checkDarkMode = () => {
//         if (
//             localStorage.getItem("darkMode") === "enabled" ||
//             (localStorage.getItem("darkMode") === null &&
//                 window.matchMedia("(prefers-color-scheme: dark)").matches)
//         ) {
//             document.documentElement.classList.add("dark");
//         }
//     };

//     // Initialize
//     checkDarkMode();
//     setupDarkMode();
//     animateHero();
// });
