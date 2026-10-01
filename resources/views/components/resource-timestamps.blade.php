@props(['model' => null])

<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">created at: </label><span class="ms-2">{{ $model?->created_at?->format('H:i d/m/Y') ?? 'Not saved yet' }}</span>
</div>
<div class="form-item second justify-content-between mt-2 d-flex align-items-sm-center">
<label class="item-title meta-title">updated at:</label><span class="ms-2">{{ $model?->updated_at?->format('H:i d/m/Y') ?? 'Not saved yet' }}</span>
</div>
