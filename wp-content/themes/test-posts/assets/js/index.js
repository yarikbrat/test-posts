document.addEventListener("DOMContentLoaded", function () {
  const navLinks = document.querySelectorAll(".posts--nav a");
  const postsWrapper = document.querySelector(".posts--wrapper");
  const loadMoreLink = document.querySelector(".more-link");
  const loadMoreBtn = loadMoreLink ? loadMoreLink.querySelector("a") : null;

  function getParamsFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get("category") || "all";
    const pageParam = urlParams.get("pg");
    const pg = pageParam && !isNaN(pageParam) ? parseInt(pageParam, 10) : 1;
    return { category, pg };
  }

  let { category: categoryID, pg } = getParamsFromUrl();

  function updateUrl(isNewState = false) {
    const params = new URLSearchParams(window.location.search);
    params.set("category", categoryID);

    if (pg > 1) {
      params.set("pg", pg);
    } else {
      params.delete("pg");
    }

    const newUrl = `${window.location.pathname}?${params.toString()}`;

    if (isNewState) {
      history.pushState({ category: categoryID, pg: pg }, "", newUrl);
      console.log("push");
    } else {
      history.replaceState({ category: categoryID, pg: pg }, "", newUrl);
      console.log("replace");
    }
  }

  function loadPosts(clear = false, state) {
    if (!postsWrapper) return;

    if (clear) {
      postsWrapper.textContent = "Загрузка...";
    }

    const formData = new FormData();
    formData.append("action", "filter_posts");
    formData.append("category", categoryID);
    formData.append("pg", pg);
    formData.append("posts_per_page", pg * 9);
    formData.append("nonce", ajax_params.nonce);

    fetch(ajax_params.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) throw new Error("Ошибка сети или сервера");
        return response.json();
      })
      .then((data) => {
        if (!data.success) throw new Error("Ошибка загрузки данных");

        postsWrapper.textContent = "";
        postsWrapper.innerHTML = data.data.html;

        loadMoreLink.style.display = data.data.has_more ? "block" : "none";

        updateUrl(state);
      })
      .catch((error) => {
        console.error("Ошибка загрузки:", error);
        postsWrapper.textContent = "Произошла ошибка при загрузке.";
      });
  }
  function loadAddPosts(clear = false, state) {
    if (!postsWrapper) return;
    // console.log("work");
    const formData = new FormData();
    formData.append("action", "filter_posts");
    formData.append("category", categoryID);
    formData.append("posts_per_page", 9);
    formData.append("pg", pg);
    formData.append("nonce", ajax_params.nonce);

    fetch(ajax_params.ajax_url, {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) throw new Error("Ошибка сети или сервера");
        return response.json();
      })
      .then((data) => {
        if (!data.success) throw new Error("Ошибка загрузки данных");

        postsWrapper.innerHTML += data.data.html;

        loadMoreLink.style.display = data.data.has_more ? "block" : "none";

        updateUrl(state);
      })
      .catch((error) => {
        console.error("Ошибка загрузки:", error);
        postsWrapper.textContent = "Произошла ошибка при загрузке.";
      });
  }

  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      categoryID = this.getAttribute("data-category");
      pg = 1;
      loadPosts(true, true);
    });
  });

  if (loadMoreBtn) {
    loadMoreBtn.addEventListener("click", function (e) {
      e.preventDefault();
      pg++;
      loadAddPosts(false, true);
      // console.log("html2");
    });
  }

  window.addEventListener("popstate", function (event) {
    if (event.state) {
      categoryID = event.state.category;
      pg = event.state.pg;
    } else {
      ({ category: categoryID, pg } = getParamsFromUrl());
    }
    loadPosts(true, false);
    console.log("hi");
  });

  loadPosts(true);
});
