(function ($) {
    "use strict";

    function cirkle_color_mode() {
        /*==========================================================
        Dark-light mode
        ======================================================================*/
        window.onload = function() {
            // Dark
            const toggleSwitch = document.querySelector(
                '.header__switch__label input[type="checkbox"]'
            );

            const currentTheme = localStorage.getItem("theme");

            if (currentTheme) {
                document.documentElement.setAttribute("data-theme", currentTheme);
                if (currentTheme === "dark-mode") {
                    toggleSwitch.checked = true;
                }
            }

            function switchTheme(e) {
                if (e.target.checked) {
                    document.documentElement.setAttribute("data-theme", "dark-mode");
                    localStorage.setItem("theme", "dark-mode");
                } else {
                    document.documentElement.setAttribute("data-theme", "light-mode");
                    localStorage.setItem("theme", "light-mode");
                }
            }

            if (toggleSwitch) {
                toggleSwitch.addEventListener("change", switchTheme, false);
            }
        };
    }
    cirkle_color_mode();

})(jQuery);
