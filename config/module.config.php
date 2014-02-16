<?php
return array(
	'doctrine' => array(
		'driver' => array(
			'application_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/Application/Entity')
			),

			'orm_default' => array(
				'drivers' => array(
					'Application\Entity' => 'application_entities'
				)
			)
		)
	),
);