<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Images\StoreRequest;

use Storage;

class ImagesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$return_files = function($path) use ( &$return_files ) 
		{
			$acceptedExts = ['bmp','gif','jpeg','jpg','png'];
			$return = [];

			foreach (Storage::directories($path) as $directory) {
				$return[] =
				[
					'path' => $directory,
					'name' => explode('/', $directory)[count(explode('/', $directory)) - 1],
					'children' => $return_files($directory)
				];
			}

			foreach (Storage::files($path) as $file) {
				$explode = explode('.', $file);
				if (count($explode) <= 1) {
					continue;
				}
				$ext = $explode[count($explode) - 1];

				if (!in_array(strtolower($ext), $acceptedExts)) {
					continue;
				}

				$return[] =
				[
					'path' => $file,
					'name' => explode('/', $file)[count(explode('/', $file)) - 1]
				];
			}

			return $return;
		};

		return [
			'path' => 'uploads',
			'name' => 'uploads',
			'children' => $return_files('uploads')
		];
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request)
	{
		if ($request->file('uploader') == null) {
			return [
				'result' => 'error',
				'body' => 'No file was uploaded.'
			];
		}
		$file = $request->file('uploader');

		if (!$file->isValid()) {
			switch ($file->getError()) {
				case 1:
				case 2:
					$error = "The uploaded file size exceeds the maximum size (". humanFileSize($file->getMaxFilesize()) .").";
					break;

				case 3:
					$error = "The uploaded file was only partially uploaded.";
					break;

				case 4:
					$error = "No file was uploaded.";
					break;

				case 6:
					$error = "Contact Admin, server Error: 'UPLOAD_ERR_NO_TMP_DIR'";
					break;

				case 7:
					$error = "Contact Admin, server Error: 'UPLOAD_ERR_CANT_WRITE'";
					break;
				
				default:
					$error = "Server Error.";
					break;
			}

			return [
				'result' => 'error',
				'body' => $error
			];
		}

		$acceptedMimes = ['image/bmp','image/gif','image/jpeg','image/png'];
		if (!in_array($file->getMimeType(), $acceptedMimes)) {
			return [
				'result' => 'error',
				'body' => 'Invalid file type, only .bmp, .jpg, .jpeg, and .png files accepted'
			];
		}

		if ($request->path != 'uploads' && !in_array($request->path, Storage::allDirectories('uploads'))) {
			return [
				'result' => 'error',
				'body' => 'Upload path is invalid.'
			];
		}
		$path = $request->path;

		if (in_array("$path/". $file->getClientOriginalName(), Storage::allFiles('uploads'))) {
			return [
				'result' => 'error',
				'body' => 'File already exists.'
			];
		}

		$file->move(base_path()."/storage/app/$path/", $file->getClientOriginalName());
		return [
			'result' => 'success',
			'body' => [
				'path' => "$path/" . $file->getClientOriginalName(),
				'name' => $file->getClientOriginalName(),
			]
		];
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		if (!$request->has('file')) {
			return [
				'result' => 'error',
				'body' => 'Delete file not found.'
			];
		}
		$file = $request->file;

		if (in_array($file, Storage::allFiles('uploads'))) { // TODO, check to make sure is valid image file
			Storage::delete($file);
			return [
				'result' => 'success',
				'body' => "$file deleted."
			];
		} else {
			return [
				'result' => 'error',
				'body' => 'Delete file not found.'
			];
		}
	}

	public function createDirectory(Request $request) 
	{
		if (!$request->has('path') || !$request->has('name') || $request->name == "") {
			return [
				'result' => 'error',
				'body' => 'No directory provided.'
			];
		}
		$path = $request->path;
		$name = $request->name;

		if (preg_match("/([^A-Za-z0-9-_])/", $request->name)) {
			return [ 
				'result' => 'error', 
				'body' => "Only Alphanumeric chars, '-', & '_' allowed."
			];
		}

		if ($path != 'uploads' && !in_array($path, Storage::allDirectories('uploads'))) {
			return [
				'result' => 'error',
				'body' => "Invalid parent directory provided."
			];
		}

		if (preg_grep( "/$path\/$name/i", Storage::allDirectories('uploads'))) {
			return [
				'result' => 'error',
				'body' => "Directory already exists."
			];
		}

		Storage::makeDirectory("$path/$name");
		return [
			'result' => 'success',
			'body' => [
				'path' => "$path/$name",
				'name' => $name,
				'children' => []
			]
		];
	}

	public function deleteDirectory(Request $request) {
		if (!$request->has('path')) {
			return [
				'result' => 'error',
				'body' => 'No path provided.'
			];
		}
		$path = $request->path;

		if (in_array($path, Storage::allDirectories('uploads'))) {
			Storage::deleteDirectory($path);
			return [
				'result' => 'success',
				'body' => "Directory '$path' was successfully deleted."
			];
		} else {
			return [
				'result' => 'error',
				'body' => "Directory '$path', was not found."
			];
		}
	}
}