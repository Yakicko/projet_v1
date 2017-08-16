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

    public function indexAction($id_region)
    {
        $region = $this->app['region.repository']->find($id_region);
        $Rdetail = $this->app['regiondetail.repository']->find($id_region);
        $topRegions =$this->app['recipe.repository']->top($id_region);

        return $this->render('region/index.html.twig',
            [
                'region' => $region,
                'regionDetail' => $Rdetail,
                'topRegions' =>$topRegions
            ]
        );
    }
}