<?php

namespace Controller;

use Entity\User;
use Entity\Region;

class UserController extends ControllerAbstract
{
    public function registerAction()
    {
        $user = new User();
        $errors = [];
        $regionList = [];

        if (!empty($_POST)) {
            $user
                ->setLastname($_POST['lastname'])
                ->setFirstname($_POST['firstname'])
                ->setEmail($_POST['email'])
                ->setUsername($_POST['username'])
                ->setCivility($_POST['civility'])
                ->setPassword($_POST['password'])
                ->setId_region($_POST['id_region'])
                ->setStatus('membre');

            if (empty($_POST['lastname'])) {
                $errors['lastname'] = 'Le nom est obligatoire';
            } elseif (strlen($_POST['lastname']) > 100) {
                $errors['lastname'] = 'Le nom ne doit pas faire plus de 100 caractères';
            }

            if (empty($_POST['firstname'])) {
                $errors['firstname'] = 'Le prénom est obligatoire';
            } elseif (strlen($_POST['firstname']) > 100) {
                $errors['firstname'] = 'Le prénom ne doit pas faire plus de 100 caractères';
            }

            if (empty($_POST['email'])) {
                $errors['email'] = 'L\'email est obligatoire';
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'L\'email n\'est pas valide';
            } elseif (!empty($this->app['user.repository']->findByEmail($_POST['email']))) {
                $errors['email'] = 'Cet email est déjà utilisé';
            }

            if (empty($_POST['password'])) {
                $errors['password'] = 'Un mot de passe est obligatoire';
            } elseif (!preg_match('/^[a-zA-Z0-9_-]{6,20}$/', $_POST['password'])) {
                $errors['password'] = 'Le mot de passe doit faire entre 6 et 20 caractères' . ' et ne contenir que des lettres, des chiffres, ou les caractères _ et -';
            }

            if (empty($_POST['password_confirm'])) {
                $errors['password_confirm'] = 'Veuillez confirmer votre mot de passe';
            } elseif ($_POST['password_confirm'] != $_POST['password']) {
                $errors['password_confirm'] = 'La confirmation n\'est pas identique au mot de passe';
            }

            if (empty($_POST['username'])) {
                $errors['username'] = 'Le pseudo est obligatoire';
            } elseif (!empty($this->app['user.repository']->isUnique($_POST['username']))) {
                $errors['username'] = 'Ce pseudo est déjà utilisé';
            }

            if (empty($errors)) {
                $user->setPassword($this->app['user.manager']->encodePassword($_POST['password']));
                $this->app['user.repository']->save($user);

                return $this->redirectRoute('user_login');

            } else {
                $message = '<strong>Le formulaire contient des erreurs</strong>';
                $message .= '<br>' . implode('<br>', $errors);
                $this->addFlashMessage($message, 'error');
            }

        }

        $regionsList = $this->app["region.repository"]->findAll();


        return $this->render(
            'user/register.html.twig',
            [
                'user' => $user,
                'regions' => $regionsList
            ]
        );
    }

    public function loginAction()
    {
        $username = '';
        $email = "";

        if (!$this->app["user.manager"]->getUser()) {

            if (!empty($_POST)) {

                $username = $_POST['login'];
                $email = $_POST['login'];

                if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                    $user = $this->app['user.repository']->findByEmail($email);
                } else {
                    $user = $this->app['user.repository']->findByUsername($username);
                }


                if (!is_null($user)) {
                    if ($this->app['user.manager']->verifyPassword($_POST['password'], $user->getPassword())) {
                        $this->app['user.manager']->login($user);


                        if (isset($_GET['redirect'])) {
                            // a changer pour profil
                            return $this->app->redirect($_GET['redirect']);
                        } else {
                            return $this->redirectRoute('homepage');
                        }
                    }
                }
                $this->addFlashMessage('Identification incorrecte', 'error');
            }
        } else {
            return $this->redirectRoute('homepage');
        }

        return $this->render(
            'user/login.html.twig',
            ['username' => $username]
        );
    }

    public function logoutAction()
    {
        $this->app['user.manager']->logout();

        return $this->redirectRoute('homepage');
    }

    public function profilAction()
    {
        if ($this->app["user.manager"]->getUser()) {
            $user = $this->app["user.manager"]->getUser();
            $region = $this->app["region.repository"]->find($user->getId_region());
            $nb_myRecipe = $this->app["user.repository"]->myRecipe($user->getId_user());
            $nb_myComments = $this->app["user.repository"]->myComments($user->getId_user());
            $nb_myRatings = $this->app["user.repository"]->myRatings($user->getId_user());
        } else {
            return $this->redirectRoute('user_login');
        }
        return $this->render(
            "user/profil.html.twig",
            [
                "user" => $user,
                'region' => $region,
                'nb_myRecipe' => $nb_myRecipe,
                'nb_myComments' => $nb_myComments,
                'nb_myRatings' => $nb_myRatings
            ]
        );
    }

    public function profilPublicAction($id_user)
    {
        $user = $this->app['user.repository']->find($id_user);
        $region = $this->app["region.repository"]->find($user->getId_region());
        $nb_myRecipe = $this->app["user.repository"]->myRecipe($user->getId_user());
        $nb_myComments = $this->app["user.repository"]->myComments($user->getId_user());
        $nb_myRatings = $this->app["user.repository"]->myRatings($user->getId_user());


        return $this->render(
            "user/profil_public.html.twig",
            [
                "user" => $user,
                'region' => $region,
                'nb_myRecipe' => $nb_myRecipe,
                'nb_myComments' => $nb_myComments,
                'nb_myRatings' => $nb_myRatings
            ]
        );
    }


}