<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;

trait UploadFilesTraits {

	/**
	 * Upload Any File
	 * @param $request
	 * @param string $input input name
	 * @param string $folder folder name
	 * @param string $disk
	 * @return object
	 */
    public function uploadFile($request, $input, $folder, $disk = 'local', $rename = true) {

		$the_file = $request->file($input);

		if ( $the_file->isValid() ) {
			$file_name = $rename ? $the_file->hashName() : str_replace(" ", "-", $the_file->getClientOriginalName()); //Name with extension 'filename.jpg'
			$file_title =  explode('.', $file_name)[0]; // Filename 'filename'
			$file_size = number_format($the_file->getSize() / 1024, 1); // get size in kb
			$file_dimensions = [
				'width' => getimagesize($the_file)[0],
				'height' => getimagesize($the_file)[1]
			];

			$file_path = $the_file->storeAs($folder, $file_name, $disk);

			return response()->json([
				'name' => $file_name,
				'title' => $file_title,
				'size' => $file_size,
				'path' => $file_path,
				'dimensions' => $file_dimensions,
			]);
		}

		return;
    }

}
