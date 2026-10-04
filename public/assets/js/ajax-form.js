(function () {
    'use strict';

    var SUMMARY_ATTR = 'data-ajax-form-summary';
    var FEEDBACK_ATTR = 'data-ajax-form-feedback';

    function csrfToken(form) {
        var input = form.querySelector('input[name="_token"]');
        if (input && input.value) {
            return input.value;
        }
        var meta = document.querySelector('meta[name="_token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function cssEscape(value) {
        if (window.CSS && typeof window.CSS.escape === 'function') {
            return window.CSS.escape(value);
        }
        return String(value).replace(/\\/g, '\\\\').replace(/"/g, '\\"');
    }

    function dotKeyToBracketName(key) {
        var parts = key.split('.');
        var name = parts.shift();
        parts.forEach(function (part) {
            name += '[' + part + ']';
        });
        return name;
    }

    function candidateNames(key) {
        var names = [];
        names.push(dotKeyToBracketName(key));
        names.push(key);
        if (key.indexOf('.') === -1) {
            names.push(key + '[]');
        }
        var withoutIndex = key.replace(/\.\d+/g, '');
        if (withoutIndex !== key) {
            names.push(dotKeyToBracketName(withoutIndex));
            names.push(withoutIndex + '[]');
            names.push(dotKeyToBracketName(withoutIndex) + '[]');
        }
        var arrayStem = key.replace(/(\.\d+)+$/, '');
        if (arrayStem !== key && names.indexOf(arrayStem + '[]') === -1) {
            names.push(arrayStem + '[]');
            names.push(dotKeyToBracketName(arrayStem) + '[]');
        }
        return names.filter(function (value, index, list) {
            return list.indexOf(value) === index;
        });
    }

    function findFieldTarget(form, key) {
        var names = candidateNames(key);
        var i;
        for (i = 0; i < names.length; i++) {
            var selector = '[name="' + cssEscape(names[i]) + '"]';
            var field = form.querySelector(selector);
            if (field) {
                return field;
            }
        }
        return (
            form.querySelector('[data-error-for="' + cssEscape(key) + '"]') ||
            form.querySelector('[data-error-for="' + cssEscape(key.replace(/\.\d+/g, '')) + '"]') ||
            form.querySelector('[data-error-for="' + cssEscape(key.replace(/\.\d+$/, '')) + '"]')
        );
    }

    function clearFormErrors(form) {
        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        form.querySelectorAll('[' + FEEDBACK_ATTR + ']').forEach(function (el) {
            el.remove();
        });
        var summary = form.querySelector('[' + SUMMARY_ATTR + ']');
        if (summary) {
            summary.classList.add('d-none');
            summary.classList.remove('show');
            var list = summary.querySelector('[data-ajax-form-summary-list]');
            if (list) {
                list.innerHTML = '';
            }
        }
    }

    function ensureSummary(form) {
        var summary = form.querySelector('[' + SUMMARY_ATTR + ']');
        if (summary) {
            return summary;
        }
        summary = document.createElement('div');
        summary.className = 'alert alert-danger alert-dismissible fade ajax-form-error-summary d-none';
        summary.setAttribute(SUMMARY_ATTR, '');
        summary.setAttribute('role', 'alert');
        summary.innerHTML =
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
            '<ul class="mb-0 ps-3" data-ajax-form-summary-list></ul>';
        form.insertBefore(summary, form.firstChild);
        return summary;
    }

    function feedbackHost(target) {
        if (!target) {
            return null;
        }
        if (target.hasAttribute('data-error-for')) {
            return target;
        }
        if (target.matches('input[type="checkbox"], input[type="radio"]')) {
            return (
                target.closest('[data-error-for]') ||
                target.closest('.form-item, .cat-list-holder, .my-list-holder, .product-variant-rows') ||
                target.closest('label') ||
                target
            );
        }
        if (target.matches('select') && target.classList.contains('multi-select')) {
            return target.closest('.form-item') || target;
        }
        return target;
    }

    function showFieldError(form, key, message) {
        var target = findFieldTarget(form, key);
        if (!target) {
            return false;
        }
        var host = feedbackHost(target);
        host.classList.add('is-invalid');
        var feedback = document.createElement('div');
        feedback.className = 'invalid-feedback d-block';
        feedback.setAttribute(FEEDBACK_ATTR, '');
        feedback.textContent = message;
        host.insertAdjacentElement('afterend', feedback);
        return true;
    }

    function applyValidationErrors(form, errors) {
        var unmapped = [];
        var firstHost = null;

        Object.keys(errors).forEach(function (key) {
            var raw = errors[key];
            var message = Array.isArray(raw) ? raw[0] : String(raw);
            if (!showFieldError(form, key, message)) {
                unmapped.push({ key: key, message: message });
            } else if (!firstHost) {
                firstHost = feedbackHost(findFieldTarget(form, key));
            }
        });

        if (unmapped.length) {
            var summary = ensureSummary(form);
            var list = summary.querySelector('[data-ajax-form-summary-list]');
            unmapped.forEach(function (item) {
                var li = document.createElement('li');
                li.textContent = item.message;
                list.appendChild(li);
            });
            summary.classList.remove('d-none');
            summary.classList.add('show');
            if (!firstHost) {
                summary.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        if (firstHost) {
            if (typeof firstHost.focus === 'function' && firstHost.matches('input, select, textarea, button')) {
                firstHost.focus();
            }
            firstHost.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function showErrorAlert(title, text) {
        if (window.AdminTableActions && typeof window.AdminTableActions.showErrorToast === 'function') {
            window.AdminTableActions.showErrorToast(text || title);
            return;
        }
        if (typeof Swal === 'undefined') {
            window.alert(text || title || 'Error');
            return;
        }
        Swal.fire({
            icon: 'error',
            titleText: title || 'Oops...',
            text: text || '',
            showConfirmButton: true,
            confirmButtonColor: 'var(--main-color)',
        });
    }

    function showSuccess(json) {
        var message = json.message || json.text || json.title || '';
        var redirect = json.redirect || null;
        var successFn = window.AdminSwalSuccess;

        if (typeof successFn !== 'function') {
            if (redirect) {
                window.location.href = redirect;
            }
            return;
        }

        successFn({
            titleText: message || undefined,
            text: message ? undefined : '',
            willClose: function () {
                if (redirect) {
                    window.location.href = redirect;
                }
            },
        }).then(function () {
            if (redirect) {
                window.location.href = redirect;
            }
        });
    }

    function parseJsonSafe(response) {
        return response.text().then(function (body) {
            if (!body) {
                return null;
            }
            try {
                return JSON.parse(body);
            } catch (e) {
                return null;
            }
        });
    }

    function setSubmitting(form, submitting) {
        form.setAttribute('aria-busy', submitting ? 'true' : 'false');
        form.querySelectorAll('button, input[type="submit"]').forEach(function (control) {
            if (control.type === 'button' && control.hasAttribute('data-ajax-form-trigger')) {
                control.disabled = submitting;
                return;
            }
            if (control.type === 'submit' || (control.tagName === 'BUTTON' && !control.type)) {
                control.disabled = submitting;
            }
        });
    }

    function applySubmitterStatus(form, submitter) {
        if (!submitter) {
            return;
        }
        var status = submitter.getAttribute('data-ajax-status');
        if (!status) {
            return;
        }
        var statusInput = form.querySelector('[name="status"]');
        if (statusInput) {
            statusInput.value = status;
        }
    }

    function submitAjaxForm(form, submitter) {
        if (!form.hasAttribute('novalidate') && typeof form.reportValidity === 'function' && !form.reportValidity()) {
            return;
        }

        applySubmitterStatus(form, submitter);
        clearFormErrors(form);
        setSubmitting(form, true);

        var formData = new FormData(form);
        var headers = {
            'X-CSRF-TOKEN': csrfToken(form),
            'X-Requested-With': 'XMLHttpRequest',
            Accept: 'application/json',
        };

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: headers,
            credentials: 'same-origin',
            redirect: 'follow',
        })
            .then(function (response) {
                var contentType = response.headers.get('content-type') || '';
                if (response.status === 422) {
                    return parseJsonSafe(response).then(function (json) {
                        if (json && json.errors) {
                            applyValidationErrors(form, json.errors);
                        } else {
                            showErrorAlert('Validation failed', json && json.message ? json.message : 'Validation failed.');
                        }
                    });
                }

                if (contentType.indexOf('application/json') !== -1) {
                    return parseJsonSafe(response).then(function (json) {
                        json = json || {};
                        if (response.ok && json.success !== false && !json.errors) {
                            showSuccess(json);
                            return;
                        }
                        if (json.errors) {
                            var errText = Array.isArray(json.errors)
                                ? json.errors.join('\n')
                                : Object.keys(json.errors)
                                      .map(function (k) {
                                          var v = json.errors[k];
                                          return Array.isArray(v) ? v[0] : v;
                                      })
                                      .join('\n');
                            showErrorAlert(json.message || 'Error', errText);
                            return;
                        }
                        showErrorAlert('Error', json.message || 'Request failed.');
                    });
                }

                if (response.ok) {
                    window.location.href = response.url;
                    return;
                }

                showErrorAlert('Error', 'Request failed (' + response.status + ').');
            })
            .catch(function () {
                showErrorAlert('Error', 'Network error. Please try again.');
            })
            .finally(function () {
                setSubmitting(form, false);
            });
    }

    function bindForm(form) {
        if (form.dataset.ajaxFormBound === '1') {
            return;
        }
        form.dataset.ajaxFormBound = '1';

        form.querySelectorAll('[data-ajax-form-trigger]').forEach(function (button) {
            button.addEventListener('click', function () {
                applySubmitterStatus(form, button);
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit(button);
                } else {
                    submitAjaxForm(form, button);
                }
            });
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            submitAjaxForm(form, event.submitter || null);
        });
    }

    function init() {
        document.querySelectorAll('form[data-ajax-form]').forEach(bindForm);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
