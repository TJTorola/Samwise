<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;

use Storage;
use Image;

class OfferPicture extends Model
{
	public static function processImage($tmp_file, $offer_id, $sorting)
	{
		$ext = pathinfo($tmp_file, PATHINFO_EXTENSION);
		$filename = pathinfo($tmp_file, PATHINFO_FILENAME);

		// Make the image to modify
		$root = base_path()."/storage/app";
		$image = Image::make("$root/$tmp_file");

		// Resize md Image, and copy to dir
		$image->resize(400, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
		})->save("$root/tmp/$filename.md.$ext");

		// Resize sm image, and copy to dir
		$image->fit(200)->save("$root/tmp/$filename.sm.$ext");

		$offer = Offer::find($offer_id);
		$picture = new self(['sorting' => $sorting, 'ext' => $ext]);
		$offer->pictures()->save($picture);

		Storage::move($tmp_file, "inventory/$picture[id]lg.$ext");
		Storage::move("tmp/$filename.md.$ext", "inventory/$picture[id]md.$ext");
		Storage::move("tmp/$filename.sm.$ext", "inventory/$picture[id]sm.$ext");

		return $picture;
	}

	public static function saveMany($pictures, $offer_id)
	{
		foreach ($pictures as $index => $picture) {
			if ($picture['id'] === null) {
				self::processImage($picture['source']['lg'], $offer_id, $index);
			} else {
				$picture = self::find($picture['id']);
				$picture->sorting = $index;
				$picture->save();
			}
		}
	}

	/*
	|--------------------------------------------------------------------------
	| Eloquent Configuration
	|--------------------------------------------------------------------------
	*/

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['source'];

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'created_at', 'updated_at', 'source'];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [];

	/*
	|--------------------------------------------------------------------------
	| Eloquent Relations
	|--------------------------------------------------------------------------
	*/

	/**
	 * An picture belogs to an offer
	 */
	public function offer()
	{
		return $this->belongsTo('App\Offer');
	}

	/*
	|--------------------------------------------------------------------------
	| Computed Properties
	|--------------------------------------------------------------------------
	*/

	public function getSourceAttribute()
	{
		return [
			'lg' => "inventory/$this[id]lg.$this[ext]",
			'md' => "inventory/$this[id]md.$this[ext]",
			'sm' => "inventory/$this[id]sm.$this[ext]"
		];
	}

	/*
	|--------------------------------------------------------------------------
	| Return Arrays
	|--------------------------------------------------------------------------
	*/
	
}
