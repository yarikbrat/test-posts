document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".posts--nav a");
  const postsWrapper = document.querySelector(".posts--wrapper");
  const loadMoreLink = document.querySelector(".more-link");
  const loadMoreBtn = loadMoreLink ? loadMoreLink.querySelector("a") : null;
  let page = 1;
  let categoryID = "";

  function getCategoryFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get("category") ? urlParams.get("category") : "all";
  }

  categoryID = getCategoryFromUrl();

  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      categoryID = this.getAttribute("data-category");

      let newUrl = window.location.href.split("?")[0];
      if (categoryID && categoryID !== "all") {
        newUrl = `${newUrl}?category=${categoryID}`;
      }

      history.pushState({ path: newUrl }, "", newUrl);

      page = 1;
      loadPosts();
    });
  });

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", function (e) {
      e.preventDefault();
      page++;
      loadPosts();
    });
  }

  function loadPosts() {
    if (!postsWrapper) return;

    if (page === 1) {
      postsWrapper.innerHTML = "<p>Загрузка...</p>";
    }

    const formData = new FormData();
    formData.append("action", "filter_posts");
    formData.append("category", categoryID);
    formData.append("page", page);
    formData.append("nonce", ajax_params.nonce);

    fetch(ajax_params.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Ошибка сети или сервера");
        }
        return response.json();
      })
      .then((data) => {
        if (!data.success) {
          throw new Error("Ошибка загрузки данных");
        }

        if (page === 1) {
          postsWrapper.innerHTML = data.data.html;
        } else {
          postsWrapper.innerHTML += data.data.html;
        }

        if (!data.data.has_more) {
          loadMoreLink.style.display = "none";
        } else {
          loadMoreLink.style.display = "block";
        }
      })
      .catch((error) => {
        console.error("Ошибка загрузки:", error);
        postsWrapper.innerHTML = "<p>Произошла ошибка при загрузке.</p>";
      });
  }

  window.addEventListener("popstate", function () {
    categoryID = getCategoryFromUrl();
    page = 1;
    loadPosts();
  });

  loadPosts();
});
