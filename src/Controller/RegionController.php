<?php

namespace Controller;

class RegionController extends ControllerAbstract
{
	public function listAction()
	{
		
		$regions = $this->app['region.repository']->findAll();

		return $this->render(
			'index.html.twig',
			[
				'regions' => $regions
			]
		);
	}
}