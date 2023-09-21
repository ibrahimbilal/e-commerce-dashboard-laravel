<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LanguageController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// available_languages() = Helper fn
		$langs = array_to_object(available_languages());
		return view('admin.langs.list', compact('langs'));
    }

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$all_langs = langs_list();
		return view('admin.langs.add', compact('all_langs'));
    }

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		try {

			// get selected lang
			$selected_lang = $request->get('lang');

			// check if the lang not exist
			if ( array_search($selected_lang, array_column(available_languages(), 'code')) === false ) {
				if (is_dir(App::langPath() . '/en')) {
					// copy en lang files to new lang folder
					$done = File::copyDirectory(App::langPath() . '/en', App::langPath() . '/' . $selected_lang);

					if ( $done ) {
						return response()->json([
							'success' => true,
							'text' => __('alerts.langs.response.create'),
							'redirect' => route('langs.index')
						]);
					}
				}
			}

		} catch ( \Exception $ex ) {
			return response()->json([
				'errors' => [__('alerts.response.errors.unknown')]
			]);
		}
	}

	/**
     * Show the form for editing the specified resource.
     *
     * @param String $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
		// check if the slug is valid
		$path = App::langPath() . '/' . $slug;
		if (is_dir($path)) {
			$files = File::allFiles($path);
			$contents = [];

			foreach( $files as $file ) {
				if ( $file->getExtension() === 'php' ) {
					$contents[] = [
						'file_name' => $file->getFilename(),
						'file_content' => $file
					];
				}
			}

			// $contents = array_to_object($contents);
			return view('admin.langs.edit', compact('contents'));
		}

    }
}
