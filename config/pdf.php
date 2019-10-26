<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir' => __DIR__ . '/custom/temp/dir/path',
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'xbriyaz' => [
			'R'  => 'XB Riyaz.ttf',    // regular font
			'B'  => 'XB RiyazBd.ttf',       // optional: bold font
			'I'  => 'XB RiyazIt.ttf',     // optional: italic font
			'BI' => 'XB RiyazBdIt.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		]
	]
];
