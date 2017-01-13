<?php

	return [

		// Validaciones personalizadas
		'musica' => [
			'nombre' => [
				'required' => 'El campo es obligatorio.',
				'min'      => 'Utiliza como minimo 2 caracteres.',
				'max'      => 'Utiliza como maximo 60 caracteres.',
				''         => 'El nombre ingresado no es valido.'
			]
		],

		'attributes' => [],
	];
