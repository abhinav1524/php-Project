document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;
  const navbar = document.getElementById("navbar");
  const toggleDarkMode = document.getElementById("toggleDarkMode");
  const darkModeIcon = document.getElementById("darkModeIcon");

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
  paginatedData.forEach((item, key) => {
    const row = `
          <tr>
            <td style="background-color:transparent">${key + 1}</td>
            <td style="background-color:transparent">${item.name}</td>
            <td style="background-color:transparent">${item.slug}</td>
            <td style="background-color:transparent">
                <div class="d-flex justify-content-around align-items-center">
                     <a href="update.php?id=${
                       item.id
                     }" class="btn btn-warning edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="#" class="btn btn-danger delete-btn" data-id="${
                      item.id
                    }"><i class="fa-solid fa-trash-can"></i></a>
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
    // console.log(jsonData); //

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
  paginatedData.forEach((item, key) => {
    const row = `
          <tr>
            <td style="background-color:transparent">${key + 1}</td>
            <td style="background-color:transparent">${item.name}</td>
            <td style="background-color:transparent">${item.slug}</td>
            <td style="background-color:transparent">
                <div class="d-flex justify-content-around align-items-center">
                     <a href="update.php?id=${
                       item.id
                     }" class="btn btn-warning edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="#" class="btn btn-danger delete-tag-btn" data-id="${
                      item.id
                    }"><i class="fa-solid fa-trash-can"></i></a>
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

// fetching the post data //
async function fetchPostData() {
  let postData = [];
  try {
    const response = await fetch(`../post/post.php?fetchAll=true`); // Fetch data from the backend
    if (!response.ok) {
      throw new Error("Failed to fetch data");
    }
    const jsonData = await response.json(); // Parse JSON response
    console.log(jsonData); //

    if (jsonData.error) {
      console.error("Error:", jsonData.error);
      return;
    }

    postData = jsonData; // Assign the fetched data to the `data` variable
    displayPostTable(postData, currentPage); // Display the first page of the data
    setupPagination(postData); // Set up pagination based on the fetched data
  } catch (error) {
    console.error("Error fetching data:", error);
  }
}
// Call fetchData with the table name
fetchPostData();
// Function to display the table data
function displayPostTable(data, page) {
  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const paginatedData = data.slice(startIndex, endIndex);
  // console.log(paginatedData);
  const tableBody = document.getElementById("posts-table-body");
  tableBody.innerHTML = "";
  paginatedData.forEach((item, key) => {
    const normalizedImagePath = `../../images/${item.image.split("\\").pop()}`;
    const row = `
          <tr>
            <td style="background-color:transparent">${key + 1}</td>
            <td style="background-color:transparent">${item.title}</td>
            <td style="background-color:transparent">${item.slug}</td>
            <td style="background-color:transparent">${item.author}</td>
            <td style="background-color:transparent">${item.description}</td>
            <td style="background-color:transparent">${item.category_name}</td>
            <td style="background-color:transparent"><img src ="${normalizedImagePath}" style="max-width: 80px; max-height:80px"/></td>
            <td style="background-color:transparent">
                <div class="d-flex justify-content-between align-items-center">
                     <a href="update.php?id=${
                       item.id
                     }" class="btn btn-warning edit-btn" style="margin-right:8px"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="#" class="btn btn-danger delete-post-btn" data-id="${
                      item.id
                    }"><i class="fa-solid fa-trash-can"></i></a>
                </div>
            </td>
          </tr>
        `;
    tableBody.innerHTML += row;
  });
}

// delete button for post //
document.addEventListener("DOMContentLoaded", () => {
  const tableBody = document.querySelector("table tbody");

  tableBody.addEventListener("click", async (event) => {
    if (event.target.classList.contains("delete-post-btn")) {
      // console.log("entered in delte code ");
      event.preventDefault();

      const postId = event.target.getAttribute("data-id");
      // console.log(postId);
      const confirmDelete = confirm(
        "Are you sure you want to delete this post?"
      );

      if (confirmDelete) {
        try {
          const response = await fetch("post.php", {
            method: "DELETE",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id: postId }),
          });

          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }

          const result = await response.json();
          console.log(result);
          if (result.success) {
            alert(result.message || "Post deleted successfully.");
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

// filter the post for tabs categories //
document.addEventListener("DOMContentLoaded", function () {
  const tabButtons = document.querySelectorAll(".tab-btn");
  const posts = document.querySelectorAll(".blog-post");

  tabButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const targetCategory = this.textContent.trim();
      posts.forEach((post) => {
        const postCategory = post.getAttribute("data-category");
        console.log(postCategory);
        if (targetCategory === "All" || postCategory === targetCategory) {
          post.style.display = "block";
        } else {
          post.style.display = "none";
        }
      });
    });
  });
});

// javascript to handle the reply button click and form submission//
document.addEventListener("DOMContentLoaded", function () {
  // Toggle reply form display
  document.querySelectorAll(".reply-btn").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const commentId = this.getAttribute("data-comment-id");
      const replyForm = document.querySelector(
        `.reply-form-container[data-comment-id="${commentId}"]`
      );

      if (replyForm) {
        replyForm.style.display =
          replyForm.style.display === "none" ? "flex" : "none";
      }
    });
  });
});

// javascript to handle the edit button click to show and hide the form//
document.addEventListener("DOMContentLoaded", function () {
  // Toggle reply form display
  document.querySelectorAll(".repy_edit").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const commentId = this.getAttribute("data-comment-id");
      const replyForm = document.querySelector(
        `.update-form-container[data-comment-id="${commentId}"]`
      );

      if (replyForm) {
        replyForm.style.display =
          replyForm.style.display === "none" ? "flex" : "none";
      }
    });
  });
});

// ajax call to delete the comment
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".reply_delete").forEach((button) => {
    button.addEventListener("click", function () {
      var commentId = this.getAttribute("data-comment-id");
      if (confirm("Are you sure you want to delete this comment?")) {
        // Perform the DELETE request using Fetch API
        fetch("comment/comment.php", {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ comment_id: commentId }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              alert(data.message); // Success message
              // Optionally, remove the comment element from the DOM
              var commentElement = document.querySelector(
                `.comment[data-comment-id="${commentId}"]`
              );
              if (commentElement) {
                commentElement.remove();
              }
              location.reload();
            } else {
              alert(data.error); // Error message
              console.log(data.error);
            }
          })
          .catch((error) => {
            alert("An error occurred: " + error.message);
            // console.log(error.message);
          });
      } else {
        // User canceled the deletion
        alert("Comment deletion was canceled.");
      }
    });
  });
});
