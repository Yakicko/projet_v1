<?php

namespace Repository;

use Entity\Region;

class RegionRepository extends RepositoryAbstract
{
	protected function getTable()
	{
		return 'regions';
	}

	public function findAll()
	{
		$dbRegions = $this->db->fetchAll('SELECT * FROM regions');

		$regions = [];

		foreach($dbRegions as $dbRegion){
			$region = $this->buildEntity($dbRegion);

			$regions[] = $region;
		}

		return $regions;
	}

	public function find($id_region)
	{
		$dbRegion = $this->db->fetchAssoc(
			'SELECT * FROM regions WHERE id_region = :id_region',
			[
				':id_region' => $id_region
			]
		);
		if(!empty($dbRegion)){
			return $this->buildEntity($dbRegion);
		}
	}

	private function buildEntity(array $data)
	{
		$region = new Region();

			$region
				->setId_region($data['id_region'])
				->setRegion_name($data['region_name'])
			;

			return $region;
	}

}