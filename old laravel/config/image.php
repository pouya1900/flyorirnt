<?php
return [
	'sizes' => [
		'logo'  => [
			'tiny'     => [
				'postfix' => '_tiny',
				'width'   => 48,
				'height'  => 48
			],
			'small'    => [
				'postfix' => '_x-small',
				'width'   => 72,
				'height'  => 72
			],
			'medium'   => [
				'postfix' => '_small',
				'width'   => 96,
				'height'  => 96
			],
			'large'    => [
				'postfix' => '_medium',
				'width'   => 144,
				'height'  => 144
			],
			'big'      => [
				'postfix' => '_large',
				'width'   => 192,
				'height'  => 192
			],
			'standard' => [
				'postfix' => '_standard',
				'width'   => 768,
				'height'  => ""
			]
		],
		'image' => [
			'tiny'     => [
				'postfix' => '_tiny',
				'width'   => 72,
				'height'  => 72
			],
			'x-small'  => [
				'postfix' => '_x-small',
				'width'   => 144,
				'height'  => 144
			],
			'small'    => [
				'postfix' => '_small',
				'width'   => 192,
				'height'  => 192
			],
			'medium'   => [
				'postfix' => '_medium',
				'width'   => 340,
				'height'  => 340
			],
			'large'    => [
				'postfix' => '_large',
				'width'   => 540,
				'height'  => 540
			],
			'standard' => [
				'postfix' => '_standard',
				'width'   => 768,
				'height'  => ""
			]
		],
	],

	'validTypes' => [
		'logo',
		'image',
		'video'
	],

	'validModels' => [

		'post',
		'page',
		'avatar',
		'settings',
		'cars'
	],

	'ModelsToType' => [

		'post'      => "image",
		'page' => "image",
		'avatar'       => "image",
		'settings'       => "image",
		'cars'       => "image",

	],

	'storage' => [
		'global' => 'assetsStorage'
	],
];
