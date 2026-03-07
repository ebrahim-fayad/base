const THEME_STORAGE_KEY = "caberz_currentLayout";

function getBody() {
    return document.getElementById("content_body");
}

function getStoredTheme() {
    const stored = window.localStorage.getItem(THEME_STORAGE_KEY);

    if (stored === "dark" || stored === "light") {
        return stored;
    }

    return null;
}

function resolveTheme() {
    return getStoredTheme() || (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light");
}

function themeIcon(theme) {
    return theme === "dark" ? "icon-sun" : "icon-moon";
}

function themeLabel(theme) {
    const lang = document.documentElement.lang || "en";

    if (theme === "dark") {
        return lang === "ar" ? "الوضع الداكن" : "Dark mode";
    }

    return lang === "ar" ? "الوضع الفاتح" : "Light mode";
}

function syncDirection() {
    const html = document.documentElement;
    const direction = html.getAttribute("dir") || html.getAttribute("data-textdirection") || "ltr";

    html.setAttribute("data-textdirection", direction);

    const body = getBody();
    if (body) {
        body.dataset.direction = direction;
    }
}

function updateThemeToggles(theme) {
    document.querySelectorAll("[data-theme-toggle]").forEach((toggle) => {
        toggle.setAttribute("aria-pressed", String(theme === "dark"));
        toggle.setAttribute("title", themeLabel(theme));

        toggle.innerHTML = `
            <i class="ficon feather ${themeIcon(theme)}"></i>
            <span class="admin-theme-toggle__label">${themeLabel(theme)}</span>
        `;
    });
}

function applyTheme(theme) {
    const html = document.documentElement;
    const body = getBody();

    html.setAttribute("data-theme", theme);
    html.setAttribute("data-bs-theme", theme);

    if (!body) {
        return;
    }

    body.dataset.type = theme;
    body.dataset.theme = theme;

    body.classList.toggle("dark-layout", theme === "dark");
    body.classList.toggle("light-mode", theme !== "dark");

    window.localStorage.setItem(THEME_STORAGE_KEY, theme);
    updateThemeToggles(theme);

    window.dispatchEvent(new CustomEvent("admin:theme-changed", { detail: { theme } }));
}

function toggleTheme() {
    const nextTheme = (getBody()?.dataset.theme || resolveTheme()) === "dark" ? "light" : "dark";
    applyTheme(nextTheme);
}

function bindThemeToggle() {
    document.addEventListener("click", (event) => {
        const toggle = event.target.closest("[data-theme-toggle]");

        if (!toggle) {
            return;
        }

        event.preventDefault();
        toggleTheme();
    });
}

document.addEventListener("DOMContentLoaded", () => {
    syncDirection();
    applyTheme(resolveTheme());
    bindThemeToggle();
});

window.changeMode = toggleTheme;
