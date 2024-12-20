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
let rowsPerPage = 5; // Number of rows to display per page
let currentPage = 1; // Current page number
let data = []; // Placeholder for fetched data

// Function to fetch data from the server
async function fetchCategoryData() {
  try {
    // console.log(`Fetching data for table: ${tableName}`);
    const response = await fetch(`../category/category.php?fetchAll=true`); // Fetch data from the backend
    if (!response.ok) {
      throw new Error("Failed to fetch data");
    }
    const jsonData = await response.json(); // Parse JSON response
    // console.log(jsonData); //

    if (jsonData.error) {
      console.error("Error:", jsonData.error);
      return;
    }

    data = jsonData; // Assign the fetched data to the `data` variable
    displayTable(data, currentPage); // Display the first page of the data
    setupPagination(data); // Set up pagination based on the fetched data
  } catch (error) {
    console.error("Error fetching data:", error);
  }
}
// Call fetchData with the table name
fetchCategoryData();
// Function to display the table data
function displayTable(data, page) {
  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const paginatedData = data.slice(startIndex, endIndex);

  const tableBody = document.getElementById("table-body");
  tableBody.innerHTML = "";
  paginatedData.forEach((item) => {
    const row = `
          <tr>
            <td style="background-color:transparent">${item.id}</td>
            <td style="background-color:transparent">${item.name}</td>
            <td style="background-color:transparent">${item.slug}</td>
            <td style="background-color:transparent">
                <div class="d-flex justify-content-around align-items-center">
                     <a href="update.php?id=${item.id}" class="btn btn-warning edit-btn">Edit</a>
                    <a href="#" class="btn btn-danger delete-btn" data-id="${item.id}">Delete</a>
                </div>
            </td>
          </tr>
        `;
    tableBody.innerHTML += row;
  });
}
// delete button code //
document.addEventListener("DOMContentLoaded", () => {
  const tableBody = document.querySelector("table tbody");

  tableBody.addEventListener("click", async (event) => {
    if (event.target.classList.contains("delete-btn")) {
      event.preventDefault();

      const categoryId = event.target.getAttribute("data-id");
      const confirmDelete = confirm(
        "Are you sure you want to delete this category?"
      );

      if (confirmDelete) {
        try {
          const response = await fetch("category.php", {
            method: "DELETE",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: categoryId }),
          });

          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }

          const result = await response.json();

          if (result.success) {
            alert(result.message || "Category deleted successfully.");
            event.target.closest("tr").remove();
          } else {
            alert("Error: " + result.error);
          }
        } catch (error) {
          console.error("Error:", error);
          alert("An error occurred: " + error.message);
        }
      }
    }
  });
});

// Function to set up pagination
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

// Function to handle page changes
function changePage(page) {
  currentPage = page;
  displayTable(data, currentPage); // Display the new page
  setupPagination(data); // Recreate pagination with the active page highlighted
}

// fetching the tag data //
async function fetchTagData() {
  let tagData = [];
  try {
    // console.log(`Fetching data for table: ${tableName}`);
    const response = await fetch(`../tag/tag.php?fetchAll=true`); // Fetch data from the backend
    if (!response.ok) {
      throw new Error("Failed to fetch data");
    }
    const jsonData = await response.json(); // Parse JSON response
    console.log(jsonData); //

    if (jsonData.error) {
      console.error("Error:", jsonData.error);
      return;
    }

    tagData = jsonData; // Assign the fetched data to the `data` variable
    displayTagTable(tagData, currentPage); // Display the first page of the data
    setupPagination(tagData); // Set up pagination based on the fetched data
  } catch (error) {
    console.error("Error fetching data:", error);
  }
}
// Call fetchData with the table name
fetchTagData();
// Function to display the table data
function displayTagTable(data, page) {
  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const paginatedData = data.slice(startIndex, endIndex);
  // console.log(paginatedData);
  const tableBody = document.getElementById("tag-table-body");
  tableBody.innerHTML = "";
  paginatedData.forEach((item) => {
    const row = `
          <tr>
            <td style="background-color:transparent">${item.id}</td>
            <td style="background-color:transparent">${item.name}</td>
            <td style="background-color:transparent">${item.slug}</td>
            <td style="background-color:transparent">
                <div class="d-flex justify-content-around align-items-center">
                     <a href="update.php?id=${item.id}" class="btn btn-warning edit-btn">Edit</a>
                    <a href="#" class="btn btn-danger delete-tag-btn" data-id="${item.id}">Delete</a>
                </div>
            </td>
          </tr>
        `;
    tableBody.innerHTML += row;
  });
}
// delete button for tags //
document.addEventListener("DOMContentLoaded", () => {
  const tableBody = document.querySelector("table tbody");

  tableBody.addEventListener("click", async (event) => {
    if (event.target.classList.contains("delete-tag-btn")) {
      event.preventDefault();

      const tagId = event.target.getAttribute("data-id");
      const confirmDelete = confirm(
        "Are you sure you want to delete this tag?"
      );

      if (confirmDelete) {
        try {
          const response = await fetch("tag.php", {
            method: "DELETE",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: tagId }),
          });

          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }

          const result = await response.json();

          if (result.success) {
            alert(result.message || "Tag deleted successfully.");
            event.target.closest("tr").remove(); // Remove the table row
          } else {
            alert("Error: " + result.error);
          }
        } catch (error) {
          console.error("Error:", error);
          alert("An error occurred: " + error.message);
        }
      }
    }
  });
});
