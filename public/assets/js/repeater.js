(function () {
    'use strict';

    var INDEX_PLACEHOLDER = '__INDEX__';

    function holderRows(holder) {
        return Array.prototype.slice.call(holder.querySelectorAll(':scope > .repeater[data-repeater-row]'));
    }

    function minRows(holder) {
        var value = holder.getAttribute('data-repeater-min');
        if (value === null || value === '') {
            return 0;
        }
        return parseInt(value, 10) || 0;
    }

    function templateForHolder(holder) {
        var templateId = holder.getAttribute('data-repeater-template');
        if (!templateId) {
            return null;
        }
        return document.getElementById(templateId);
    }

    function nextRowIndex(holder) {
        var maxIndex = -1;
        holder.querySelectorAll('[name]').forEach(function (input) {
            var match = input.name.match(/\[(\d+)\]/);
            if (!match) {
                return;
            }
            maxIndex = Math.max(maxIndex, parseInt(match[1], 10));
        });
        return maxIndex + 1;
    }

    function replaceIndexTokens(root, index) {
        var indexStr = String(index);
        root.querySelectorAll('[name]').forEach(function (el) {
            if (el.name.indexOf(INDEX_PLACEHOLDER) !== -1) {
                el.name = el.name.split(INDEX_PLACEHOLDER).join(indexStr);
            }
        });
        root.querySelectorAll('[id]').forEach(function (el) {
            if (el.id.indexOf(INDEX_PLACEHOLDER) !== -1) {
                el.id = el.id.split(INDEX_PLACEHOLDER).join(indexStr);
            }
        });
        root.querySelectorAll('label[for]').forEach(function (el) {
            var token = el.getAttribute('for');
            if (token && token.indexOf(INDEX_PLACEHOLDER) !== -1) {
                el.setAttribute('for', token.split(INDEX_PLACEHOLDER).join(indexStr));
            }
        });
    }

    function openRepeater(repeater) {
        if (!repeater) {
            return;
        }
        if (window.jQuery) {
            var $repeater = window.jQuery(repeater);
            $repeater.find('.repeater-inputs').slideDown();
            $repeater.find('.icon').addClass('active');
            $repeater.siblings('.repeater').find('.repeater-inputs').slideUp();
            $repeater.siblings('.repeater').find('.icon').removeClass('active');
            return;
        }
        var inputs = repeater.querySelector('.repeater-inputs');
        if (inputs) {
            inputs.style.display = 'block';
            inputs.classList.add('active');
        }
        repeater.querySelectorAll('.icon').forEach(function (icon) {
            icon.classList.add('active');
        });
    }

    function syncTitleFromInput(input) {
        var row = input.closest('.repeater');
        if (!row) {
            return;
        }
        var display = row.querySelector('[data-repeater-title-display]');
        if (!display) {
            return;
        }
        var fallback = input.getAttribute('data-repeater-title-fallback') || 'Row';
        var value = (input.value || '').trim();
        display.textContent = value !== '' ? value : fallback;
    }

    function isValidHexColor(value) {
        return /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test(String(value || '').trim());
    }

    function normalizeHexColor(value) {
        var trimmed = String(value || '').trim();
        if (/^#?[0-9a-fA-F]{3}$/.test(trimmed)) {
            var short = trimmed.replace('#', '');
            return (
                '#' +
                short
                    .split('')
                    .map(function (char) {
                        return char + char;
                    })
                    .join('')
            );
        }
        if (/^#?[0-9a-fA-F]{6}$/.test(trimmed)) {
            return trimmed.charAt(0) === '#' ? trimmed : '#' + trimmed;
        }
        return '#000000';
    }

    function syncTermValueInput(select) {
        var row = select.closest('.repeater');
        if (!row) {
            return;
        }
        var valueInput = row.querySelector('[data-term-value-input]');
        if (!valueInput) {
            return;
        }
        var isColor = select.value === 'color';
        if (isColor) {
            if (valueInput.type !== 'color') {
                var textValue = valueInput.value || valueInput.getAttribute('data-term-text-value') || '';
                valueInput.setAttribute('data-term-text-value', textValue);
                valueInput.type = 'color';
                valueInput.value = isValidHexColor(textValue) ? normalizeHexColor(textValue) : '#000000';
            }
            return;
        }
        if (valueInput.type === 'color') {
            var colorValue = valueInput.value;
            valueInput.type = 'text';
            valueInput.value = valueInput.getAttribute('data-term-text-value') || colorValue || '';
        }
    }

    function toggleEmptyTermsAlert(holder) {
        var alertBox = holder.parentElement
            ? holder.parentElement.querySelector('[data-repeater-empty-alert]')
            : null;
        if (!alertBox) {
            return;
        }
        if (holderRows(holder).length === 0) {
            alertBox.classList.remove('d-none');
        } else {
            alertBox.classList.add('d-none');
        }
    }

    function addRow(holder) {
        var template = templateForHolder(holder);
        if (!template || !template.content) {
            return;
        }
        var index = nextRowIndex(holder);
        var fragment = template.content.cloneNode(true);
        replaceIndexTokens(fragment, index);
        holder.appendChild(fragment);
        var rows = holderRows(holder);
        var newRow = rows[rows.length - 1];
        openRepeater(newRow);
        toggleEmptyTermsAlert(holder);
        var titleInput = newRow.querySelector('[data-repeater-title-input]');
        if (titleInput) {
            syncTitleFromInput(titleInput);
        }
        var typeSelect = newRow.querySelector('[data-term-type-select]');
        if (typeSelect) {
            syncTermValueInput(typeSelect);
        }
    }

    function bindHolder(holder) {
        if (holder.dataset.repeaterBound === '1') {
            return;
        }
        holder.dataset.repeaterBound = '1';

        holder.addEventListener(
            'click',
            function (event) {
                var removeBtn = event.target.closest('.remove');
                if (!removeBtn || !holder.contains(removeBtn)) {
                    return;
                }
                var row = removeBtn.closest('.repeater');
                if (!row || !holder.contains(row)) {
                    return;
                }
                var rows = holderRows(holder);
                var minimum = minRows(holder);
                if (rows.length <= minimum) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    return;
                }
                row.remove();
                toggleEmptyTermsAlert(holder);
            },
            true
        );

        holder.addEventListener('input', function (event) {
            if (event.target.matches('[data-repeater-title-input]')) {
                syncTitleFromInput(event.target);
            }
        });

        holder.addEventListener('change', function (event) {
            if (event.target.matches('[data-term-type-select]')) {
                syncTermValueInput(event.target);
            }
        });

        var addWrap = holder.parentElement ? holder.parentElement.querySelector('.add-repeater-item .btn') : null;
        if (addWrap) {
            addWrap.addEventListener('click', function (event) {
                event.preventDefault();
                addRow(holder);
            });
        }

        holder.querySelectorAll('[data-term-type-select]').forEach(syncTermValueInput);
        holder.querySelectorAll('[data-repeater-title-input]').forEach(syncTitleFromInput);
        toggleEmptyTermsAlert(holder);
    }

    function init() {
        document.querySelectorAll('.repeater-holder[data-repeater-template]').forEach(bindHolder);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    window.AdminRepeater = {
        openRepeater: openRepeater,
    };
})();
