<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 10/08/2017
 * Time: 10:07
 */

namespace Repository;

use Entity\Recipe;

class RecipeRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'recipes';
    }

    public function findAll()
    {
        $query = "SELECT r.id_recipe, r.id_region, r.id_user, r.title, r.picture_recipe, r.star_ingredient, r.difficulty, r.prep_time, r.cook_time, r.portion, r.ingredients, r.methods, r.story, r.status, s.region_name, u.username FROM recipes r" 
                . " JOIN regions s ON r.id_region = s.id_region"
                . " JOIN users u ON r.id_user = u.id_user"
                . " WHERE r.status = 'En attente'"
        ;

        $dbRecipes = $this->db->fetchAll($query);

        $recipes = [];

        foreach ($dbRecipes as $dbRecipe)
        {
            $recipe = $this->buildEntity($dbRecipe);

            $recipes[] = $recipe;
        }

        return $recipes;
    }

    public function find($id_recipe)
    {
        $query = 'SELECT r.*, s.region_name FROM recipes r' 
                . ' JOIN regions s ON r.id_region = s.id_region'
                . ' WHERE id_recipe = :id_recipe'
        ;

        $dbRecipe = $this->db->fetchAssoc($query,
            [
                ':id_recipe' => $id_recipe
            ]
        );

        if (!empty($dbRecipe))
        {
            return $this->buildEntity($dbRecipe);
        }
    }

    public function save(Recipe $recipe)
    {
        // Les données à enregistrer en BDD
        $data = [
            'title' => $recipe->getTitle(),
            'star_ingredient' => $recipe->getStar_ingredient(),
            'difficulty' => $recipe->getDifficulty(),
            'prep_time' => $recipe->getPrep_time(),
            'cook_time' => $recipe->getCook_time(),
            'portion' => $recipe->getPortion(),
            'ingredients' => $recipe->getIngredients(),
            'methods' => $recipe->getMethods(),
            'story' => $recipe->getStory(),
            'id_region' => $recipe->getId_region(),
            'picture_recipe' => $recipe->getPicture_recipe(),
            'status' => $recipe->getStatus()
        ];

        // Appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data);

        // On défini l'id quand on est en insert (setId())
        if (empty($recipe->getId_recipe()))
        {
            $recipe->setId_recipe($this->db->lastInsertId());
        }
    }

    public function validRecipe(Recipe $recipe)
    {
        $data = [
            'status' => 'validée'
        ];

        $this->persist($data, ['id_recipe' => $recipe->getId_recipe()]);
    }

    public function delete (Recipe $recipe)
    {
        $this->db->delete(
            'recipes',
                ['id_recipe' => $recipe->getId_recipe()]
        );
    }

    private function buildEntity(array $data)
    {
        $recipe = new Recipe();

        $recipe
            ->setId_recipe($data['id_recipe'])
            ->setId_region($data['id_region'])
            ->setId_user($data['id_user'])
            ->setTitle($data['title'])
            ->setStar_ingredient($data['star_ingredient'])
            ->setPrep_time($data['prep_time'])
            ->setCook_time($data['cook_time'])
            ->setPicture_recipe($data['picture_recipe'])
            ->setDifficulty($data['difficulty'])
            ->setPortion($data['portion'])
            ->setIngredients($data['ingredients'])
            ->setMethods($data['methods'])
            ->setStory($data['story'])
            ->setStatus($data['status'])
        ;

        if (isset($data['region_name'])) {
            $recipe->setRegionName($data['region_name']);
        }

        if (isset($data['username'])) {
            $recipe->setUserName($data['username']);
        }

        return $recipe;
    }
}