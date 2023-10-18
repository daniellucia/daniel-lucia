document.addEventListener("DOMContentLoaded", function () {
    const el = document.querySelector("div.site-header-container")
    console.log(el)
    const observer = new IntersectionObserver(
        ([e]) => e.target.classList.toggle("is-pinned", e.intersectionRatio < 1),
        { threshold: [1] }
    );

    observer.observe(el);
});