<?php
/**
 * Created by PhpStorm.
 * User: Ričardas
 * Date: 14.8.13
 * Time: 15.06
 */

namespace Acme\FirstBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function commentAction(Request $request)
    {
        ini_set('xdebug.max_nesting_level', 200);
        $id = 'thread_id';
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (null === $thread) {
            $thread = $this->container->get('fos_comment.manager.thread')->createThread();
            $thread->setId($id);
            $thread->setPermalink($request->getUri());

            // Add the thread
            $this->container->get('fos_comment.manager.thread')->saveThread($thread);
        }

        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);

        return $this->render('AcmeFirstBundle:Comment:comment.html.twig', array(
            'comments' => $comments,
            'thread' => $thread,
        ));
    }
}
