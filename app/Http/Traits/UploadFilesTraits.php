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
	 * @return string file path
	 */
    public function uploadFile($request, $input, $folder, $disk = 'local') {

		if ( $request->file($input)->isValid() ) {
			$file_name = $request->file($input)->hashName();
			$file_path = $request->file($input)->storeAs($folder, $file_name, $disk);

			return $file_path;
		}

		return;
    }

}
