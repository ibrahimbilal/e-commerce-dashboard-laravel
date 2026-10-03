<div class="main-box box-spaces">
	<div class="row">
		<div class="col-sm-5 col-lg-12 d-flex justify-content-center align-items-center">
			<div class="img-view text-center">
				<img src="{{ URL::asset('storage/' . $image->url) }}">
			</div>
		</div>
		<div class="col-sm-7 col-lg-12">
			<form id="edit-image-gallery" data-id="{{ $image->id }}">
				@method('PUT')
				<table class="mt-2 w-100">
					<tbody>
						<tr>
							<td class="py-2">
								<div class="form-item second">
									<label class="item-title meta-title">{{ __('metas.file_name') }}</label>
								</div>
							</td>
							<td class="py-2">
								<div class="form-item second">
									<span class="ps-2">{{ $image->metas['name'] }}</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="py-2">
								<div class="form-item second">
									<label class="item-title meta-title">{{ __('metas.file_size') }}</label>
								</div>
							</td>
							<td class="py-2">
								<div class="form-item second">
									<span class="ps-2">{{ $image->metas['size'] . 'KB' }}</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="py-2">
								<div class="form-item second">
									<label
										class="item-title meta-title">{{ __('metas.updated_at') }}</label>
								</div>
							</td>
							<td class="py-2">
								<div class="form-item second"><span class="ps-2">{{ $image->updated_at }}</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="py-2">
								<div class="form-item second">
									<label
										class="item-title meta-title">{{ __('metas.upload_by') }}</label>
								</div>
							</td>
							<td class="py-2">
								<div class="form-item second">
									<span class="ps-2">{{ $image->user->first_name }} {{ $image->user->last_name }}</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="py-2">
								<div class="form-item second">
									<label class="item-title meta-title">{{ __('metas.image_quality') }}</label>
								</div>
							</td>
							<td class="py-2">
								<div class="form-item second">
									<span class="ps-2">{{ $image->metas['width'] }} x {{ $image->metas['height'] }}</span>
								</div>
							</td>
						</tr>
						<tr>
							<td class="py-2">
								<div class="form-item second">
									<label
										class="item-title meta-title">{{ __('metas.image_url') }}</label>
								</div>
							</td>
							<td class="py-2">
								<div class="form-item second">
									<input class="form-control ps-2"
										value="{{ url( 'storage/' . $image->url) }}"
										disabled readonly>
								</div>
							</td>
						</tr>
						<tr>
							<td class="py-2">
								<div class="form-item second">
									<label
										class="item-title meta-title">{{ __('metas.image_title') }}</label>
								</div>
							</td>
							<td class="py-2">
								<div class="form-item second">
									<input class="form-control ps-2" name="image_title" value="{{ $image->metas['title'] }}">
								</div>
							</td>
						</tr>
						<tr>
							<td class="py-2">
								<div class="form-item second">
									<label
										class="item-title meta-title">{{ __('metas.image_alt') }}</label>
								</div>
							</td>
							<td class="py-2">
								<div class="form-item second">
									<input class="form-control ps-2" name="image_alt" value="{{ $image->metas['alt'] }}">
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="btns-holder d-flex justify-content-between mt-4">
					<a href="{{ route('gallery.destroy', $image->id) }}"
						class="btn trans-btn text-start delete"
						data-confirm-delete="soft"
						data-confirm-ajax
						data-http-method="DELETE"
						data-remove-gallery
						data-id="{{ $image->id }}">
						<span class="icon me-1">
							<i class="fi-rr-trash"> </i>
						</span>{{ __('buttons.delete') }}</a>
					<button class="btn solid-btn" type="submit">{{ __('buttons.save') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>
