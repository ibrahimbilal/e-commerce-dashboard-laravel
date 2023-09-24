<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Traits\UploadFilesTraits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UploadGalleryRequest;

class GalleryController extends Controller
{
	use UploadFilesTraits;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$photos = Gallery::all()->sortDesc();
		return view('admin.gallery.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UploadGalleryRequest $request)
    {
		try {

			$logged_in_user_id = Auth::user()->id;

			if ( $request->hasFile('filepond') ) {
				$uploaded_file = $this->uploadFile($request, 'filepond', 'uploads', 'public', false);
				$file_data = $uploaded_file->getData();

				$image = New Gallery;
				$image->url = $file_data->path;
				$image->metas = [
					'name' => $file_data->name,
					'title' => $file_data->title,
					'alt' => '',
					'size' => $file_data->size,
					'width' => $file_data->dimensions->width,
					'height' => $file_data->dimensions->height,
				];
				$image->user_id = $logged_in_user_id;
				$image->save();
			}

		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

			$image = Gallery::find($id);

			if (!$image) {
				return response()->json(['errors' => [__('alerts.images.response.errors.not_exist')]]);
			}

			// Validate image data
			$validator = Validator::make($request->only(['image_title', 'image_alt']), [
				'image_title' => 'string|max:225|nullable',
				'image_alt' => 'string|max:225|nullable',
			]);

			// check if there is errors
			if ($validator->fails()) {
				return response()->json([
					'errors' => [__('alerts.errors.unknown')]
				]);
			}

			// get image metas
			$metas = $image->metas;
			// change meta
			$metas['title'] = $request->get('image_title');
			$metas['alt'] = $request->get('image_alt');

			// set new metas
			$image->metas = $metas;
			// save data
			$image->save();

			return response()->json([
				'success' => true,
				'title' => __('alerts.images.response.update')
			]);

		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
			$image = Gallery::find($id);

			if (!$image) {
				return response()->json(['errors' => [__('alerts.images.response.errors.not_exist')]]);
			}

			$img_url = 'public/' . $image->url;

			if ( Storage::exists( $img_url ) ) {
				Storage::delete( $img_url );
			}

			$image->delete();

			return response()->json([
				'success' => true,
				'title' => __('alerts.images.response.delete.title'),
				'text' => __('alerts.images.response.delete.text')
			]);

		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
    }

	function get_image_meta(Request $request)
	{

		try {
			// Validate and check image id
			$validator = Validator::make($request->only(['id']), [
				'id' => 'required|exists:App\Models\Gallery,id'
			]);

			if ($validator->fails()) {
				return response()->json([
					'errors' => [__('alerts.errors.unknown')]
				]);
			}

			$image_id = $request->only(['id']);
			$image = Gallery::find($image_id)->first();

			if ( !$image ) {
				return response()->json([
					'errors' => __('alerts.users.response.errors.not_exist')
				]);
			}

			$output = View::make("components.image-details", compact('image'))->render();

			return response()->json([
				'success' => true,
				'output' => $output
			]);


		} catch (\Exception $ex) {
			return response()->json(['errors' => [__('alerts.errors.unknown')]]);
		}
	}
}
