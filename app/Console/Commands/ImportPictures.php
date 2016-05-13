<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Database\Eloquent\Model;
use Storage;
use App\Offer;
use App\OfferPicture;

class ImportPictures extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:pictures';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
			parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		Model::unguard();
		$files = Storage::allFiles("inventory");
		foreach ($files as $file) {
			if (!preg_match('/inventory\/\d+\/lg\/\d+.\w+/', $file)) {
				continue;
			}

			$mod_file = ltrim($file, 'inventory/');
			$mod_file = explode('/lg/', $mod_file);
			$offer_id = $mod_file[0];
			$mod_file = explode('.', $mod_file[1]);
			$sorting = $mod_file[0];
			$ext = $mod_file[1];

			$lg = $file;
			$md = preg_replace('/lg/', 'md', $lg);
			$sm = preg_replace('/lg/', 'sm', $lg);

			$offer = Offer::find($offer_id);
			$picture = new OfferPicture(['sorting' => $sorting ]);
			$offer->pictures()->save($picture);

			Storage::move($lg, "inventory/$picture[id]lg.$ext");
			Storage::move($md, "inventory/$picture[id]md.$ext");
			Storage::move($sm, "inventory/$picture[id]sm.$ext");

			$this->comment($picture->id);
		}
		Model::reguard();
	}
}
