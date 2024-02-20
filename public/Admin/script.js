function formatDateTime() {
    const now = new Date();
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const dayOfMonth = ('0' + now.getDate()).slice(-2);
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    let hours = ('0' + now.getHours()).slice(-2);
    let minutes = ('0' + now.getMinutes()).slice(-2);
    let seconds = ('0' + now.getSeconds()).slice(-2);

    const formattedDateTime = `${dayOfMonth} ${month} ${year} | ${hours}:${minutes}:${seconds}`;

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