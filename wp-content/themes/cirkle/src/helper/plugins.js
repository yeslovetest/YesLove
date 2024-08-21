const existsInDOM = function (selector) {
    return document.querySelectorAll(selector).length;
};

const plugins = {
    createDropdown: function (options) {
        if (((existsInDOM(options.container) || typeof options.containerElement !== 'undefined') && options.controlToggle) || ((existsInDOM(options.trigger) || typeof options.triggerElement !== 'undefined') && (existsInDOM(options.container) || typeof options.containerElement !== 'undefined'))) {
            return new XM_Dropdown(options);
        }
    },
    createTooltip: function (options) {
        if (existsInDOM(options.container) || (typeof options.containerElement !== 'undefined')) {
            return new XM_Tooltip(options);
        }
    },
    createPopup: function (options) {
        if ((existsInDOM(options.trigger) || typeof options.triggerElement !== 'undefined') || (typeof options.premadeContentElement !== 'undefined')) {
            return new XM_Popup(options);
        }
    },
    createFormInput: function (elements) {
        for (const el of elements) {
            if (el.classList.contains('always-active')) continue;

            const input = el.querySelector('input'),
                textarea = el.querySelector('textarea'),
                activeClass = 'active';

            let inputItem = undefined;

            if (input) inputItem = input;
            if (textarea) inputItem = textarea;

            if (inputItem) {
                // if input item has value or is already focused, activate it
                if ((inputItem.value !== '') || (inputItem === document.activeElement)) {
                    el.classList.add(activeClass);
                }

                inputItem.addEventListener('focus', function () {
                    el.classList.add(activeClass);
                });

                inputItem.addEventListener('blur', function () {
                    if (inputItem.value === '') {
                        el.classList.remove(activeClass);
                    }
                });
            }
        }
    }
};

export default plugins;