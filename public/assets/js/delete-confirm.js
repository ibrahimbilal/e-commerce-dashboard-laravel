(function () {
    'use strict';

    if (typeof Swal === 'undefined') {
        return;
    }

    var messages = window.AdminDeleteConfirmMessages || {};
    var tableActions = window.AdminTableActions;
    var swalDefaults = {
        showConfirmButton: true,
        confirmButtonColor: 'var(--main-color)',
        confirmButtonText: messages.ok || 'OK',
        scrollbarPadding: false,
    };

    function modeCopy(mode, label) {
        var withLabel = function (template, fallback) {
            if (!label) {
                return fallback;
            }
            return template.replace(':label', label);
        };

        if (mode === 'restore') {
            return {
                title: messages.title || 'Are you sure?',
                text: messages.restoreText || 'Do you really want to restore this item!',
                yes: messages.restoreYes || 'Yes, restore it!',
                no: messages.no || 'No, cancel!',
                cancelText: messages.cancelRestoreText || 'item is not restored :(',
            };
        }

        if (mode === 'permanent') {
            return {
                title: messages.title || 'Are you sure?',
                text: withLabel(
                    messages.permanentTextLabel || 'Do you really want to permanently delete this :label? This cannot be undone!',
                    messages.permanentText || 'Do you really want to permanently delete this item? This cannot be undone!'
                ),
                yes: messages.permanentYes || 'Yes, delete it permanently!',
                no: messages.no || 'No, cancel!',
                cancelText: messages.cancelDeleteText || 'item is safe :)',
            };
        }

        return {
            title: messages.title || 'Are you sure?',
            text: withLabel(
                messages.softTextLabel || 'Do you really want to move this :label to trash?',
                messages.softText || 'Do you really want to delete this item!'
            ),
            yes: messages.softYes || 'Yes, delete it!',
            no: messages.no || 'No, cancel!',
            cancelText: messages.cancelDeleteText || 'item is safe :)',
        };
    }

    function showCancelToast(copy) {
        Swal.fire({
            ...swalDefaults,
            title: messages.cancelTitle || 'Cancelled',
            text: copy.cancelText,
            icon: 'error',
            timer: 1500,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    }

    function resolveForm(trigger) {
        if (trigger.form) {
            return trigger.form;
        }
        var formId = trigger.getAttribute('form');
        if (formId) {
            return document.getElementById(formId);
        }
        return trigger.closest('form[data-confirm-delete]');
    }

    function submitForm(form) {
        form.dataset.confirmDeleteSubmitted = '1';
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
        } else {
            form.submit();
        }
    }

    function runConfirmedAction(trigger) {
        if (trigger.hasAttribute('data-confirm-ajax') && tableActions) {
            tableActions.runTriggerAjax(trigger);
            return;
        }

        var form = resolveForm(trigger);
        if (form && tableActions && tableActions.usesJsonForm(form)) {
            tableActions.runFormJson(form, trigger);
            return;
        }

        if (form) {
            submitForm(form);
        }
    }

    function confirmAndRun(trigger, mode) {
        var label = trigger.getAttribute('data-confirm-label') || '';
        var copy = modeCopy(mode, label);

        Swal.fire({
            ...swalDefaults,
            title: copy.title,
            text: copy.text,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: copy.yes,
            cancelButtonText: copy.no,
        }).then(function (result) {
            if (result.isConfirmed) {
                runConfirmedAction(trigger);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                showCancelToast(copy);
            }
        });
    }

    document.addEventListener(
        'click',
        function (event) {
            var trigger = event.target.closest('[data-confirm-delete]');
            if (!trigger || trigger.disabled) {
                return;
            }

            if (trigger.tagName === 'FORM') {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            var mode = trigger.getAttribute('data-confirm-delete') || 'soft';
            confirmAndRun(trigger, mode);
        },
        true
    );

    document.addEventListener(
        'submit',
        function (event) {
            var form = event.target;
            if (!form.matches || !form.matches('form[data-confirm-delete]')) {
                return;
            }

            if (form.dataset.confirmDeleteSubmitted === '1') {
                delete form.dataset.confirmDeleteSubmitted;
                return;
            }

            event.preventDefault();
            var mode = form.getAttribute('data-confirm-delete') || 'soft';
            var submitter = event.submitter;
            var label = form.getAttribute('data-confirm-label') || (submitter && submitter.getAttribute('data-confirm-label')) || '';
            var copy = modeCopy(mode, label);

            Swal.fire({
                ...swalDefaults,
                title: copy.title,
                text: copy.text,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonText: copy.yes,
                cancelButtonText: copy.no,
            }).then(function (result) {
                if (result.isConfirmed) {
                    if (tableActions && tableActions.usesJsonForm(form)) {
                        tableActions.runFormJson(form, submitter);
                    } else {
                        submitForm(form);
                    }
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    showCancelToast(copy);
                }
            });
        },
        true
    );
})();
