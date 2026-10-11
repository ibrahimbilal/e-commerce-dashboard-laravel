(function () {
    'use strict';

    var modalEl;
    var imageEl;
    var applyBtn;
    var cropper;
    var currentInput;
    var pendingFile;
    var objectUrl;
    var suppressChange = false;
    var cancelled = false;

    function allowedFile(file) {
        if (!file) {
            return false;
        }
        var type = (file.type || '').toLowerCase();
        if (type === 'image/jpeg' || type === 'image/png') {
            return true;
        }
        var name = (file.name || '').toLowerCase();
        return /\.(jpe?g|png)$/.test(name);
    }

    function isPngFile(file) {
        if (!file) {
            return false;
        }
        var type = (file.type || '').toLowerCase();
        if (type === 'image/png') {
            return true;
        }
        return /\.png$/i.test(file.name || '');
    }

    function showTypeError() {
        var title = 'Oops...';
        var text = 'Please upload a JPG or PNG image.';
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                titleText: title,
                text: text,
                showConfirmButton: true,
                confirmButtonColor: 'var(--main-color)',
                scrollbarPadding: false,
            });
            return;
        }
        window.alert(text);
    }

    function itemContent(input) {
        return input ? input.closest('.item-content') : null;
    }

    function previewFor(input) {
        var wrap = itemContent(input);
        return wrap ? wrap.querySelector('img.preview') : null;
    }

    function selectedBlock(input) {
        var wrap = itemContent(input);
        return wrap ? wrap.querySelector('.selected-img') : null;
    }

    function clearObjectUrl() {
        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
            objectUrl = null;
        }
    }

    function destroyCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    function resetFileInput(input) {
        if (!input) {
            return;
        }
        suppressChange = true;
        input.value = '';
        suppressChange = false;
    }

    function setCroppedFile(input, blob, sourceFile) {
        var mime = isPngFile(sourceFile) ? 'image/png' : 'image/jpeg';
        var fileName = mime === 'image/png' ? 'profile.png' : 'profile.jpg';
        var file = new File([blob], fileName, {
            type: mime,
            lastModified: Date.now(),
        });
        var dt = new DataTransfer();
        dt.items.add(file);
        suppressChange = true;
        input.files = dt.files;
        suppressChange = false;
    }

    function clearLegacyHiddenPicture(input) {
        if (!input || !input.form) {
            return;
        }
        var hidden = input.form.querySelector('input[type="hidden"][name="profile_picture"]');
        if (hidden) {
            hidden.value = '';
        }
    }

    function markRemoveCleared(input) {
        if (!input || !input.form) {
            return;
        }
        var removeField = input.form.querySelector('#remove_pp, [name="remove_pp"]');
        if (removeField) {
            removeField.value = '0';
        }
    }

    function showSelectedBlock(block) {
        if (!block) {
            return;
        }
        block.style.display = '';
        if (window.jQuery) {
            window.jQuery(block).show(500);
        }
    }

    function closeModalCleanup() {
        destroyCropper();
        clearObjectUrl();
        if (imageEl) {
            imageEl.removeAttribute('src');
        }
        pendingFile = null;
        if (cancelled && currentInput) {
            resetFileInput(currentInput);
        }
        currentInput = null;
        cancelled = false;
    }

    function getBootstrapModal() {
        if (!modalEl) {
            return null;
        }
        if (window.bootstrap && window.bootstrap.Modal && typeof window.bootstrap.Modal.getOrCreateInstance === 'function') {
            return window.bootstrap.Modal.getOrCreateInstance(modalEl);
        }
        return null;
    }

    function showCropModal() {
        var instance = getBootstrapModal();
        if (instance && typeof instance.show === 'function') {
            instance.show();
        }
    }

    function hideCropModal() {
        if (modalEl && window.bootstrap && window.bootstrap.Modal) {
            var instance = window.bootstrap.Modal.getInstance(modalEl);
            if (instance) {
                instance.hide();
            }
        }
    }

    function openCropModal(input, file) {
        if (!modalEl || !imageEl) {
            return;
        }
        currentInput = input;
        pendingFile = file;
        cancelled = false;
        resetFileInput(input);
        clearObjectUrl();
        objectUrl = URL.createObjectURL(file);
        imageEl.src = objectUrl;
        if (!getBootstrapModal()) {
            return;
        }
        showCropModal();
    }

    function onModalShown() {
        destroyCropper();
        if (applyBtn) {
            applyBtn.disabled = true;
        }
        if (!imageEl || typeof Cropper === 'undefined') {
            return;
        }
        cropper = new Cropper(imageEl, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            background: false,
        });
        if (applyBtn) {
            applyBtn.disabled = false;
        }
    }

    function onApplyClick() {
        if (!cropper || !currentInput || !pendingFile) {
            return;
        }
        var mime = isPngFile(pendingFile) ? 'image/png' : 'image/jpeg';
        var canvas = cropper.getCroppedCanvas({
            width: 256,
            height: 256,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        if (!canvas) {
            return;
        }
        canvas.toBlob(
            function (blob) {
                if (!blob || !currentInput) {
                    return;
                }
                setCroppedFile(currentInput, blob, pendingFile);
                clearLegacyHiddenPicture(currentInput);
                markRemoveCleared(currentInput);
                var preview = previewFor(currentInput);
                if (preview) {
                    preview.src = canvas.toDataURL(mime);
                }
                showSelectedBlock(selectedBlock(currentInput));
                cancelled = false;
                hideCropModal();
            },
            mime,
            mime === 'image/png' ? undefined : 0.92
        );
    }

    function onInputChange(event) {
        var input = event.target;
        if (suppressChange || !input.matches('input[type="file"][data-pp-cropper]')) {
            return;
        }
        var file = input.files && input.files[0];
        if (!file) {
            return;
        }
        if (!allowedFile(file)) {
            resetFileInput(input);
            showTypeError();
            return;
        }
        openCropModal(input, file);
    }

    function bindModal() {
        modalEl = document.getElementById('pp-cropper-modal');
        imageEl = document.getElementById('pp-cropper-image');
        applyBtn = document.getElementById('pp-cropper-apply');
        if (!modalEl || !imageEl) {
            return;
        }
        modalEl.addEventListener('shown.bs.modal', onModalShown);
        modalEl.addEventListener('hidden.bs.modal', closeModalCleanup);
        modalEl.querySelectorAll('[data-pp-cropper-cancel]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                cancelled = true;
            });
        });
        if (applyBtn) {
            applyBtn.disabled = true;
            applyBtn.addEventListener('click', function () {
                if (!cropper) {
                    return;
                }
                onApplyClick();
            });
        }
    }

    function onRemoveOverlayClick(event) {
        var overlay = event.target.closest('.item-content .selected-img .overlay');
        if (!overlay) {
            return;
        }
        var content = overlay.closest('.item-content');
        if (!content) {
            return;
        }
        var input = content.querySelector('input[type="file"][data-pp-cropper]');
        if (!input) {
            return;
        }
        resetFileInput(input);
        clearLegacyHiddenPicture(input);
        var removeField = input.form && input.form.querySelector('#remove_pp, [name="remove_pp"]');
        if (removeField) {
            removeField.value = '1';
        }
        var preview = previewFor(input);
        if (preview) {
            preview.removeAttribute('src');
        }
        var block = selectedBlock(input);
        if (block) {
            if (window.jQuery) {
                window.jQuery(block).hide(500);
            } else {
                block.style.display = 'none';
            }
        }
    }

    function init() {
        bindModal();
        document.addEventListener('change', onInputChange);
        document.addEventListener('click', onRemoveOverlayClick);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
