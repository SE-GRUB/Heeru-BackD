function formatDateTime() {
    const now = new Date();
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const dayOfWeek = days[now.getDay()];
    const dayOfMonth = now.getDate();
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();

    hours = ('0' + hours).slice(-2);
    minutes = ('0' + minutes).slice(-2);
    seconds = ('0' + seconds).slice(-2);

    const formattedDateTime = `${dayOfWeek},${dayOfMonth} ${month} ${year}<br>${hours}:${minutes}:${seconds}`;

    document.getElementById('date-time').innerHTML = formattedDateTime;
}
formatDateTime();
setInterval(formatDateTime, 1000);

$(document).ready(function () {
    $('table').DataTable();
});

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