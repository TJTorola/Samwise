<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Database\Eloquent\Model;
use App\Offer;
use App\Item;

class ImportOffers extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:offers';

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
		$offers = config('samwise.offers');
		$items = config('samwise.items');
		$nue_offers = [];
		$id_array = [];

		foreach ($offers as $offer) {
			$type_info = json_decode($offer['type_info'], true);
			foreach ($type_info as $key => $value) {
				$offer[$key] = $value;
			}

			foreach ($items as $item) {

				if ($offer['id'] == $item['item_id']) {
					$id_array[$item['id']] = count($id_array) + 1;
					unset($item['id']);
					unset($item['item_id']);
					$item['type'] = 'auto';
					foreach (['x', 'y', 'z', 'weight', 'oversized', 'location', 'part_number', 'ss_part_number', 'ahmed'] as $key) {
						if ($offer[$key] == null) {
							continue;
						}

						$item[$key] = $offer[$key];
					}
					$item['shipping_cost'] = $offer['flat_shipping'];
					$item['price'] = intval($item['price'] * 100);

					if ($item['name'] == '') {
						$item['name'] = "$offer[state], $offer[quality]";
					}

					if (!isset($offer['items'])) {
						$offer['items'] = [];
					}

					$offer['items'][] = $item;
				}
			}

			$nue_offers[] = $offer;
		}

		// Model::unguard();
		foreach ($nue_offers as $offer) {
			$items = $offer['items'];
			unset($offer['items']);
			$offer['type_info'] = Offer::extractTypeInfo($offer);
			$offer = Offer::create($offer);

			$id = $offer->id;
			Item::saveMany($items, $id);
		}

		$this->info(json_encode($id_array));

		// Model::reguard();

		// $this->info(json_encode($new_items));
		// $offer->items()->saveMany($new_items);
	}
}
