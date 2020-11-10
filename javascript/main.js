const hamburger = document.querySelector(".menuIcon");
const header = document.querySelector("header");
const links = document.querySelectorAll(".nav_links li");

console.log(hamburger)
console.log(header)

hamburger.addEventListener("click", () => {
  header.classList.toggle("mobileMenu");
  links.forEach(link => {
    link.classList.toggle("fade");
  });
});