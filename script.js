document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;
  const navbar = document.getElementById("navbar");
  const toggleDarkMode = document.getElementById("toggleDarkMode");
  const darkModeIcon = document.getElementById("darkModeIcon");
  const rows = document.querySelectorAll("td");

  // Load dark mode preference
  if (localStorage.getItem("dark-mode") === "enabled") {
    body.classList.add("bg-dark", "text-light");
    navbar.classList.add("bg-dark", "navbar-dark");
    body.classList.remove("bg-light", "text-dark");
    navbar.classList.remove("bg-body-tertiary", "navbar-light");
    darkModeIcon.classList.replace("fa-moon", "fa-sun");
  }

  toggleDarkMode.addEventListener("click", () => {
    if (body.classList.contains("bg-dark")) {
      // Switch to light mode
      body.classList.remove("bg-dark", "text-light");
      navbar.classList.remove("bg-dark", "navbar-dark");
      body.classList.add("bg-light", "text-dark");
      navbar.classList.add("bg-body-tertiary", "navbar-light");
      darkModeIcon.classList.replace("fa-sun", "fa-moon");
      localStorage.setItem("dark-mode", "disabled");
    } else {
      // Switch to dark mode
      body.classList.add("bg-dark", "text-light");
      navbar.classList.add("bg-dark", "navbar-dark");
      body.classList.remove("bg-light", "text-dark");
      navbar.classList.remove("bg-body-tertiary", "navbar-light");
      darkModeIcon.classList.replace("fa-moon", "fa-sun");
      localStorage.setItem("dark-mode", "enabled");
    }
  });
});

// slider //
document.addEventListener("DOMContentLoaded", () => {
  const swiper = new Swiper(".swiper-container", {
    slidesPerView: 1, // Number of slides visible at a time
    spaceBetween: 10, // Space between the slides
    loop: true, // Enable infinite loop
    speed: 700,
    navigation: {
      nextEl: ".next-1",
      prevEl: ".prev-1",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    autoplay: {
      delay: 2000, // Delay in milliseconds (1 second)
      disableOnInteraction: false, // Keep autoplay running even when user interacts
    },
    breakpoints: {
      768: {
        slidesPerView: 2, // For tablets (up to 768px)
        spaceBetween: 15,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 30, // For desktops (1024px and up)
      },
    },
  });
});

// table js //
const data = [
  { id: 1, name: "John Doe", email: "john@example.com", phone: "123-456-7890" },
  {
    id: 2,
    name: "Jane Smith",
    email: "jane@example.com",
    phone: "098-765-4321",
  },
  {
    id: 3,
    name: "Mike Johnson",
    email: "mike@example.com",
    phone: "111-222-3333",
  },
  {
    id: 4,
    name: "Sara Wilson",
    email: "sara@example.com",
    phone: "444-555-6666",
  },
  { id: 5, name: "Tom Brown", email: "tom@example.com", phone: "777-888-9999" },
  {
    id: 6,
    name: "Emily Davis",
    email: "emily@example.com",
    phone: "000-123-4567",
  },
  {
    id: 7,
    name: "Chris Green",
    email: "chris@example.com",
    phone: "321-654-9870",
  },
  { id: 8, name: "Anna Lee", email: "anna@example.com", phone: "456-789-0123" },
  {
    id: 9,
    name: "David Clark",
    email: "david@example.com",
    phone: "789-012-3456",
  },
  {
    id: 10,
    name: "Jessica Moore",
    email: "jessica@example.com",
    phone: "234-567-8901",
  },
];

const rowsPerPage = 5;
let currentPage = 1;

function displayTable(data, page) {
  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const paginatedData = data.slice(startIndex, endIndex);

  const tableBody = document.getElementById("table-body");
  tableBody.innerHTML = "";
  paginatedData.forEach((item) => {
    const row = `
          <tr>
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.email}</td>
            <td>${item.phone}</td>
          </tr>
        `;
    tableBody.innerHTML += row;
  });
}

function setupPagination(data) {
  const pagination = document.getElementById("pagination");
  const totalPages = Math.ceil(data.length / rowsPerPage);

  pagination.innerHTML = "";
  for (let i = 1; i <= totalPages; i++) {
    const pageItem = `
          <li class="page-item ${i === currentPage ? "active" : ""}">
            <button class="page-link" onclick="changePage(${i})">${i}</button>
          </li>
        `;
    pagination.innerHTML += pageItem;
  }
}

function changePage(page) {
  currentPage = page;
  displayTable(data, currentPage);
  setupPagination(data);
}

// Initial setup
displayTable(data, currentPage);
setupPagination(data);
