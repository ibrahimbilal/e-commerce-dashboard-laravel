@once
<div class="modal fade" id="pp-cropper-modal" tabindex="-1" aria-labelledby="pp-cropper-modal-label" aria-hidden="true" data-bs-backdrop="static">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="pp-cropper-modal-label">{{ __('forms.profile_picture.title') }}</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-pp-cropper-cancel></button>
</div>
<div class="modal-body p-0">
<div class="pp-cropper-stage">
<img alt="" id="pp-cropper-image" src=""/>
</div>
</div>
<div class="modal-footer d-flex justify-content-between">
<button type="button" class="btn regular-btn" data-bs-dismiss="modal" data-pp-cropper-cancel>Cancel</button>
<button type="button" class="btn solid-btn" id="pp-cropper-apply">Crop</button>
</div>
</div>
</div>
</div>
@endonce
