const body = document.querySelector("body"),
      sidebar = body.querySelector("nav");
    //   sidebarToggle = body.querySelector(".sidebar-toggle");

let getStatus = localStorage.getItem("status");
if (!getStatus) {
    localStorage.setItem("status", "close");
}

sidebar.addEventListener("mouseenter", () => {
    sidebar.classList.remove("close");
    localStorage.setItem("status", "open");
});

sidebar.addEventListener("mouseleave", () => {
    sidebar.classList.add("close");
    localStorage.setItem("status", "close");
});