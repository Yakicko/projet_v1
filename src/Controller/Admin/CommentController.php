<?php


namespace Controller\Admin;

use Controller\ControllerAbstract;
use Entity\Comment;
use Entity\User;
use Entity\Recipe;


class CommentController extends ControllerAbstract
{
    public function listAction()
    {
        $comments = $this->app['comment.repository']->findAll();

        return $this->render(
                'admin/comment/list.html.twig',
                [
                    'comments' => $comments
                ]
        );
    }

    public function deleteAction($id_comment)
    {
            $comment = $this->app['comment.repository']->find($id_comment);
            
            if (!$comment instanceof Comment) {
                $this->app->abort(404);
            }
            
            $this->app['comment.repository']->delete($comment);
            
            $this->addFlashMessage('Le commentaire est supprimé');
            
            return $this->redirectRoute('admin_comments');
    }
}