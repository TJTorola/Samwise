<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
	/**
	 * Retrieve all images within the image folder
	 * GET /storage/images
	 * @return array
	 */
	public function getImages()
	{
		return [];
	}

	/**
	 * Post a new image/directory into the image folder
	 * POST /storage/images
	 * @return string
	 */
	public function postImage()
	{
		return "";
	}

	/**
	 * Delete an image/directory within the image folder
	 * DELETE /storage/images/{path*}
	 * @param string $path 
	 * @return string
	 */
	public function deleteImage($path)
	{
		return "";
	}
}