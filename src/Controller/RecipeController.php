<?php
/**
 * Created by PhpStorm.
 * User: Hello
 * Date: 10/08/2017
 * Time: 10:06
 */

namespace Controller;


use Entity\Recipe;


class RecipeController extends ControllerAbstract
{
    public function indexAction($id_recipe)
    {
        $recipe = $this->app['recipe.repository']->find($id_recipe);

        return $this->render('recipe/index.html.twig',
            ['recipe' => $recipe]);
    }

    public function listAction()
    {
        // Appel à la méthode findAll() de la classe Repository\CategoryRepository
        // Nécessite qu'elle ait été déclarée en service dans src/app.php
        $recipes = $this->app['recipe.repository']->findAll();

        return $this->render('recipe/list.html.twig',
            [
                'recipe' => $recipes
            ]
        );
    }

    public function createAction()
    {

        // Nouvelle recette
        $recipe = new Recipe();

//        // On a besoin de la liste des rubriques pour construire le select dans le formulaire
//        $categories = $this->app['category.repository']->findAll();

        $errors = [];

        $regions = $this->app['region.repository']->findAll();

        if (!empty($_POST)) {
            $recipe
                ->setTitle($_POST['title'])
                ->setStar_ingredient($_POST['star_ingredient'])
                ->setDifficulty($_POST['difficulty'])
                ->setPrep_time($_POST['prep_time'])
                ->setCook_time($_POST['cook_time'])
                ->setPortion($_POST['portion'])
                ->setIngredients($_POST['ingredients'])
                ->setMethods($_POST['methods'])
                ->setStory($_POST['story'])
                ->setId_region($_POST['id_region'])
                ->setPicture_recipe($_FILES['picture_recipe']['name']);


            if (empty($_POST['title'])) {
                $errors['title'] = 'Le titre est obligatoire';
            } elseif (strlen($_POST['title']) > 100) {
                $errors['name'] = 'Le titre ne doit pas faire plus de 100 caractères';
            }

            if (empty($_POST['star_ingredient'])) {
                $errors['star_ingredient'] = 'L\'ingrédient principal est obligatoire';
            }

            if (empty($_POST['difficulty'])) {
                $errors['difficulty'] = 'La difficulté est obligatoire';
            }

            if (empty($_POST['prep_time'])) {
                $errors['prep_time'] = 'Le temps de préparation est obligatoire';
            }

            if (empty($_POST['cook_time'])) {
                $errors['cook_time'] = 'Le temps de cuisson est obligatoire';
            }

            if (empty($_POST['portion'])) {
                $errors['portion'] = 'Le nombre de parts est obligatoire';
            }

            if (empty($_POST['ingredients'])) {
                $errors['ingredients'] = 'La liste des ingrédients est obligatoire';
            }

            if (empty($_POST['methods'])) {
                $errors['methods'] = 'Les étapes de la recette sont obligatoires';
            }

            if (empty($_POST['story'])) {
                $errors['story'] = 'L\'histoire de la recette est obligatoire';
            }

            // vérification si l'utilisateur a chargé une image
            if (!empty($_FILES['picture_recipe']['name'])) {
                // si ce n'est pas vide alors un fichier a bien été chargé via le formulaire.

                // on concatène la référence sur le titre afin de ne jamais avoir un fichier avec un nom déjà existant sur le serveur.
                $photo_bdd = $_FILES['picture_recipe']['name'];

                // vérification de l'extension de l'image (extension acceptées: jpg jpeg, png, gif)
                $extension = strrchr($_FILES['picture_recipe']['name'], '.'); // cette fonction prédéfinie permet de découper une chaine selon un caractère fourni en 2eme argument (ici le .). Attention, cette fonction découpera la chaine à partir de la dernière occurence du 2eme argument (donc nous renvoie la chaine comprise après le dernier point trouvé)
                // exemple: maphoto.jpg => on récupère .jpg
                // exemple: maphoto.photo.png => on récupère .png
                // var_dump($extension);

                // on transforme $extension afin que tous les caractères soient en minuscule
                $extension = strtolower($extension); // inverse strtoupper()
                // on enlève le .
                $extension = substr($extension, 1); // exemple: .jpg => jpg
                // les extensions acceptées
                $tab_extension_valide = array("jpg", "jpeg", "png", "gif");
                // nous pouvons donc vérifier si $extension fait partie des valeur autorisé dans $tab_extension_valide
                $verif_extension = in_array($extension, $tab_extension_valide); // in_array vérifie si une valeur fournie en 1er argument fait partie des valeurs contenues dans un tableau array fourni en 2eme argument.

                if ($verif_extension && !$errors) {
                    // si $verif_extension est égal à true et que $erreur n'est pas égal à true (il n'y a pas eu d'erreur au préalable)
                    $photo_dossier = __DIR__ . '/../../web/photo/' . $photo_bdd;

                    copy($_FILES['picture_recipe']['tmp_name'], $photo_dossier);
                    // copy() permet de copier un fichier depuis un emplacement fourni en premier argument vers un autre emplacement fourni en deuxième argument.
                } elseif (!$verif_extension) {
                    $errors['picture_recipe'] = 'Le format de la photo n\'est pas autorisé';
                }
            }

            if (empty($errors)) {
                $this->app['recipe.repository']->save($recipe);

                $this->addFlashMessage('La recette a été validée');
                return $this->redirectRoute('homepage');
            } else {
                $message = '<strong>Le formulaire contient des erreurs</strong>';
                $message .= '<br>' . implode('<br>', $errors);
                $this->addFlashMessage($message, 'error');
            }

        }

        return $this->render('recipe/create.html.twig',
            [
                'recipe' => $recipe,
                'regions' => $regions

            ]
        );
    }


}