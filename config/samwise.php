<?php

return [
	"type_schema" => [
		"offer" => [
			"auto" => [
				"Application" => [
					[
						"name" => "sI",
						"type" => "boolean"
					],
					[
						"name" => "sII",
						"type" => "boolean"
					],
					[
						"name" => "sIIA",
						"type" => "boolean"
					],
					[
						"name" => "l_sIIA",
						"type" => "boolean"
					],
					[
						"name" => "sIIB",
						"type" => "boolean"
					],
					[
						"name" => "sIII",
						"type" => "boolean"
					],
					[
						"name" => "stage_one_v8",
						"type" => "boolean"
					],
					[
						"name" => "defender",
						"type" => "boolean"
					],
					[
						"name" => "range_rover",
						"type" => "boolean"
					],
					[
						"name" => "discovery",
						"type" => "boolean"
					],
					[
						"name" => "other_applications",
						"type" => "string",
						"hint" => "Comma separated list."
					]
				],
				"Wheelbase" => [
					[
						"name" => "base_80",
						"display_name" => "80\"",
						"type" => "boolean"
					],
					[
						"name" => "base_86",
						"display_name" => "86\"",
						"type" => "boolean"
					],
					[
						"name" => "base_88",
						"display_name" => "88\"",
						"type" => "boolean"
					],
					[
						"name" => "base_107",
						"display_name" => "107\"",
						"type" => "boolean"
					],
					[
						"name" => "base_109",
						"display_name" => "109\"",
						"type" => "boolean"
					]
				]
			]
		],
		'item' => [
			'auto' => [
				[
					"name" => "part_number",
					"display_name" => "Part Number(s)",
					"type" => "string",
					"hint" => "Comma separated list."
				],
				[
					"name" => "ss_part_number",
					"display_name" => "S/S Part Number(s)",
					"type" => "string",
					"hint" => "Comma separated list."
				],
				[
					"name" => "ahmed",
					"type" => "boolean",
					"hint" => "Does Ahmed own this item?"
				],
			]
		]
	]
];