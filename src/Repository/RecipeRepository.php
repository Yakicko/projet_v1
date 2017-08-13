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
        $dbRecipes = $this->db->fetchAll('SELECT * FROM recipes');

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
        $query = 'SELECT * FROM recipes WHERE id_recipe = :id_recipe';

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
            'picture_recipe' => $recipe->getPicture_recipe()
        ];

        // Appel à la méthode de RepositoryAbstract pour enregistrer
        $this->persist($data);

        // On défini l'id quand on est en insert (setId())
        if (empty($recipe->getId_recipe()))
        {
            $recipe->setId_recipe($this->db->lastInsertId());
        }
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
            ->setStory($data['story']);

        return $recipe;
    }
}