document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("filterForm");
    const results = document.getElementById("results");

    function load(query = "") {
        fetch("search.php" + query)
            .then(res => res.text())
            .then(html => {
                results.innerHTML = html;
            });
    }

    load();

    form.querySelectorAll("input, select").forEach(el => {
        el.addEventListener("input", () => {
            const params = new URLSearchParams(new FormData(form)).toString();
            load("?" + params);
        });
    });
});
