(function () {
    'use strict';

    window.AdminSwalSuccess = function (opts) {
        if (typeof Swal === 'undefined') {
            return Promise.resolve({});
        }

        var base = {
            icon: 'success',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            scrollbarPadding: false,
            toast: true,
            position: 'top-end',
            customClass: {
                popup: 'flex-row',
            }
        };

        return Swal.fire(Object.assign({}, base, opts || {}));
    };
})();

(function () {
    'use strict';

    if (typeof Swal === 'undefined') {
        return;
    }

    var adminSwalSuccess = window.AdminSwalSuccess;

    var deleteMessages = window.AdminDeleteConfirmMessages || {};
    var messages = window.AdminTableActionMessages || {};
    var swalDefaults = {
        showConfirmButton: true,
        confirmButtonColor: 'var(--main-color)',
        confirmButtonText: deleteMessages.ok || messages.ok || 'OK',
        scrollbarPadding: false,
    };

    function csrfToken() {
        var meta = document.querySelector('meta[name="_token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function genericErrorText() {
        return messages.genericError || deleteMessages.unknownError || 'There Is Error!';
    }

    function responseMessage(body) {
        if (body && typeof body.message === 'string' && body.message.trim() !== '') {
            return body.message;
        }
        return genericErrorText();
    }

    function showErrorToast(text) {
        Swal.fire({
            ...swalDefaults,
            icon: 'error',
            titleText: deleteMessages.ops || messages.ops || 'Oops...',
            text: text || genericErrorText(),
        });
    }

    function showSuccessToast(text, title) {
        adminSwalSuccess({
            titleText: title || undefined,
            text: text || '',
        });
    }

    function parseJsonResponse(response) {
        return response
            .json()
            .catch(function () {
                return {};
            })
            .then(function (body) {
                if (!response.ok || body.success === false) {
                    var failure = body && typeof body === 'object' ? body : {};
                    failure._status = response.status;
                    throw failure;
                }
                return body;
            });
    }

    function updateFilterTabCounts(counts) {
        if (!counts || typeof counts !== 'object') {
            return;
        }

        document.querySelectorAll('.dash-filters .item[data-count-key]').forEach(function (link) {
            var key = link.getAttribute('data-count-key');
            if (!key || !Object.prototype.hasOwnProperty.call(counts, key)) {
                return;
            }
            var label = link.getAttribute('data-count-label') || link.textContent.replace(/\s*\(\d+\)\s*$/, '').trim();
            link.textContent = label + ' (' + counts[key] + ')';
        });
    }

    function tableForRow(row) {
        if (!row) {
            return null;
        }
        var table = row.closest('table');
        if (!table || typeof $ === 'undefined' || !$.fn.DataTable) {
            return null;
        }
        if ($.fn.DataTable.isDataTable(table)) {
            return $(table).DataTable();
        }
        return null;
    }

    function removeRowElement(trigger, row) {
        if (!row) {
            return;
        }

        if (trigger && trigger.hasAttribute('data-remove-gallery')) {
            var id = trigger.getAttribute('data-id');
            var item = document.querySelector('.gallery-page .img-item[data-id="' + id + '"]');
            if (item) {
                item.classList.remove('selected');
                item.remove();
            }
            var meta = document.querySelector('.gallery-page .meta-box');
            var post = document.querySelector('.gallery-page .post-box');
            if (meta) {
                meta.classList.add('hide');
                meta.innerHTML = '';
            }
            if (post) {
                post.classList.add('open');
            }
            return;
        }

        var dt = tableForRow(row);
        if (dt) {
            dt.row(row).remove().draw(false);
            return;
        }

        if (trigger && trigger.getAttribute('data-remove') === 'closest-tr') {
            row.remove();
            return;
        }

        row.remove();
    }

    function resolveTriggerRow(trigger) {
        if (!trigger) {
            return null;
        }
        return trigger.closest('tr');
    }

    function handleRoleStyleSuccess(trigger, body) {
        adminSwalSuccess({
            titleText: body.title,
            text: body.text || body.message,
            willClose: function () {
                if (body.redirect) {
                    window.location.replace(body.redirect);
                    return;
                }
                var row = resolveTriggerRow(trigger);
                removeRowElement(trigger, row);
            },
        });
    }

    function handleResourceRowSuccess(trigger, body) {
        if (body.counts) {
            updateFilterTabCounts(body.counts);
        }

        var toastText = body.message || body.text || '';
        var row = resolveTriggerRow(trigger);

        adminSwalSuccess({
            text: toastText,
            willClose: function () {
                if (trigger && trigger.hasAttribute('data-redirect-on-success') && body.redirect) {
                    window.location.replace(body.redirect);
                    return;
                }
                removeRowElement(trigger, row);
            },
        });
    }

    function applyToggleChecked(input, body) {
        var value = body.value;

        if (typeof value === 'boolean') {
            input.checked = value;
            return;
        }

        if (value === 1 || value === '1' || value === true) {
            input.checked = true;
        } else if (value === 0 || value === '0' || value === false) {
            input.checked = false;
        }
    }

    function handleToggleSuccess(input, body) {
        if (body.counts) {
            updateFilterTabCounts(body.counts);
        }
        applyToggleChecked(input, body);
        if (body.message) {
            showSuccessToast(body.message);
        }
    }

    function handleFailure(err) {
        showErrorToast(responseMessage(err));
    }

    function runFetch(url, method, trigger, bodyPayload) {
        var headers = {
            'X-CSRF-TOKEN': csrfToken(),
            Accept: 'application/json',
        };
        var options = {
            method: method,
            headers: headers,
            credentials: 'same-origin',
        };

        if (bodyPayload !== undefined) {
            headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(bodyPayload);
        }

        return fetch(url, options)
            .catch(function () {
                var networkErr = {};
                handleFailure(networkErr);
                throw networkErr;
            })
            .then(parseJsonResponse)
            .then(function (body) {
                if (trigger && trigger.hasAttribute('data-confirm-ajax') && (body.title || body.redirect)) {
                    handleRoleStyleSuccess(trigger, body);
                } else {
                    handleResourceRowSuccess(trigger, body);
                }
                return body;
            })
            .catch(function (err) {
                handleFailure(err);
                throw err;
            });
    }

    function runFormJson(form, trigger) {
        var method = 'POST';
        var methodInput = form.querySelector('[name="_method"]');
        if (methodInput && methodInput.value) {
            method = methodInput.value.toUpperCase();
        }

        return fetch(form.action, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                Accept: 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(new FormData(form)),
            credentials: 'same-origin',
        })
            .catch(function () {
                var networkErr = {};
                handleFailure(networkErr);
                throw networkErr;
            })
            .then(parseJsonResponse)
            .then(function (body) {
                handleResourceRowSuccess(trigger || form.querySelector('[data-confirm-delete]'), body);
            })
            .catch(function (err) {
                handleFailure(err);
            });
    }

    function runTriggerAjax(trigger) {
        var url = trigger.getAttribute('href') || trigger.getAttribute('data-url');
        if (!url) {
            return Promise.reject();
        }
        var method = (trigger.getAttribute('data-http-method') || 'DELETE').toUpperCase();
        return runFetch(url, method, trigger);
    }

    var toggleInputsDelegated = false;

    function handleToggleInputChange(input) {
        var url = input.getAttribute('data-toggle-url');
        var field = input.getAttribute('data-toggle-field');
        if (!url || !field) {
            return;
        }

        var priorChecked = !input.checked;
        var payload = {
            field: field,
            value: input.checked,
        };

        fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken(),
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
            credentials: 'same-origin',
        })
            .catch(function () {
                input.checked = priorChecked;
                var networkErr = {};
                handleFailure(networkErr);
                throw networkErr;
            })
            .then(parseJsonResponse)
            .then(function (body) {
                handleToggleSuccess(input, body);
            })
            .catch(function (err) {
                input.checked = priorChecked;
                handleFailure(err);
            });
    }

    function bindToggleInputs() {
        if (toggleInputsDelegated) {
            return;
        }
        toggleInputsDelegated = true;

        document.addEventListener('change', function (event) {
            var input = event.target;
            if (!input || !input.classList || !input.classList.contains('admin-field-toggle')) {
                return;
            }
            handleToggleInputChange(input);
        });
    }

    window.AdminTableActions = {
        csrfToken: csrfToken,
        showErrorToast: showErrorToast,
        showSuccessToast: showSuccessToast,
        updateFilterTabCounts: updateFilterTabCounts,
        removeRowElement: removeRowElement,
        parseJsonResponse: parseJsonResponse,
        handleFailure: handleFailure,
        runFormJson: runFormJson,
        runTriggerAjax: runTriggerAjax,
        bindToggleInputs: bindToggleInputs,
        usesJsonForm: function (form) {
            return form && form.hasAttribute('data-admin-json-row-action');
        },
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindToggleInputs);
    } else {
        bindToggleInputs();
    }
})();
