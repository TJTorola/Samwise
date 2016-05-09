<?php

namespace App;

use App\Offer;

use Storage;
use Image;

class OfferPicture
{
	/**
	 *  Return all the existing pictures for given Offer ID
	 *
	 * @return array
	 */
	static public function find($offer_id)
	{
		$files = Storage::files("inventory/$offer_id/lg");
		$accepted_mimes = ['image/jpeg', 'image/bmp', 'image/gif', 'image/png', 'image/svg+xml'];

		$pictures = [];

		foreach ($files as $index => $file) {
			if (!in_array(Storage::mimeType($file), $accepted_mimes)) {
				continue;
			}

			$stamp = Storage::lastModified($file);
			$pictures[] = [
				'source' => "$file?m=$stamp",
				'saved' => true
			];
		}

		return $pictures;
	}

	/**
	 *	Store a tmp file into its picture folder
	 *	
	 * @return int the id of the placed image
	 */
	static public function store($offer_id, $file_name)
	{
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$dir = "inventory/$offer_id";
		// Make directories incase it does not exist
		Storage::makeDirectory("$dir");
		Storage::makeDirectory("$dir/lg");
		Storage::makeDirectory("$dir/md");
		Storage::makeDirectory("$dir/sm");

		// find next availible index (ext agnostic)
		$files = Storage::files("$dir/lg");
		$index = 0;
		while (anyStartsWith("$dir/lg/$index.", $files)) {
			$index++;
		}

		// Copy to lg directory
		Storage::move("$file_name", "$dir/lg/$index.$ext");

		// Make the image to modify
		$root = base_path()."/storage/app";
		$file_name = Image::make("$root/$dir/lg/$index.$ext");

		// Resize md Image, and copy to dir
		$file_name->resize(400, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
		})->save("$root/$dir/md/$index.$ext");

		// Resize sm image, and copy to dir
		$file_name->fit(200)->save("$root/$dir/sm/$index.$ext");

		return "$index.$ext";
	}

	/**
	 *	Rearrange the images for an offer
	 *
	 *	@return bool on success of function
	 */
	static public function rearrange($offer_id, $mapping)
	{

	}



	/**
	 *
	 *
	 *
	 */
}
