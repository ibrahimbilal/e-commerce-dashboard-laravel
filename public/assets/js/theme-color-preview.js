(function () {
    'use strict';

    var configEl = document.getElementById('theme-color-preview-config');
    if (!configEl) {
        return;
    }

    var config;
    try {
        config = JSON.parse(configEl.textContent || '{}');
    } catch (error) {
        return;
    }

    var meta = config.variables || {};
    var defaults = config.defaults || {};
    var messages = config.messages || {};

    function normalizeHex(value) {
        if (typeof value !== 'string') {
            return null;
        }
        var trimmed = value.trim();
        var match = /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.exec(trimmed);
        if (!match) {
            return null;
        }
        var hex = match[1];
        if (hex.length === 3) {
            hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        return '#' + hex.toUpperCase();
    }

    function collectValues() {
        var values = {};
        Object.keys(meta).forEach(function (key) {
            var input = document.querySelector('#settings-forms [name="' + key + '"]');
            if (!input) {
                return;
            }
            values[key] = normalizeHex(input.value) || input.value;
        });
        return values;
    }

    function buildCssText(values) {
        var light = {};
        var dark = {};

        Object.keys(meta).forEach(function (key) {
            var hex = normalizeHex(values[key]);
            if (!hex) {
                return;
            }
            var mapping = meta[key];
            if (!mapping || !mapping.var) {
                return;
            }
            if (mapping.mode === 'dark') {
                dark[mapping.var] = hex;
            } else {
                light[mapping.var] = hex;
            }
        });

        function block(selector, vars) {
            var parts = Object.keys(vars).map(function (prop) {
                return prop + ':' + vars[prop];
            });
            if (!parts.length) {
                return '';
            }
            return selector + '{' + parts.join(';') + '}';
        }

        return block('html', light) + block('html.dark', dark);
    }

    function updatePreview() {
        var styleEl = document.getElementById('theme-css-variables');
        if (!styleEl) {
            return;
        }
        styleEl.textContent = buildCssText(collectValues());
    }

    function bindInputs() {
        Object.keys(meta).forEach(function (key) {
            var input = document.querySelector('#settings-forms [name="' + key + '"]');
            if (!input) {
                return;
            }
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        });
    }

    function resetToDefaults() {
        Object.keys(defaults).forEach(function (key) {
            var input = document.querySelector('#settings-forms [name="' + key + '"]');
            if (!input) {
                return;
            }
            input.value = defaults[key];
            input.dispatchEvent(new Event('input', { bubbles: true }));
        });
        updatePreview();
    }

    function swalDefaults() {
        return {
            showConfirmButton: true,
            confirmButtonColor: 'var(--main-color)',
            confirmButtonText: messages.ok || 'OK',
            scrollbarPadding: false,
        };
    }

    var resetButton = document.getElementById('reset-theme-colors');
    if (resetButton) {
        resetButton.addEventListener('click', function (event) {
            event.preventDefault();
            if (typeof Swal === 'undefined') {
                resetToDefaults();
                return;
            }

            Swal.fire({
                ...swalDefaults(),
                title: messages.confirmTitle || 'Are you sure?',
                text: messages.confirmText || 'Reset all theme colors to their defaults?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: messages.confirmYes || 'Yes, reset them!',
                cancelButtonText: messages.confirmNo || 'No, cancel!',
            }).then(function (result) {
                if (result.isConfirmed) {
                    resetToDefaults();
                }
            });
        });
    }

    bindInputs();
})();
