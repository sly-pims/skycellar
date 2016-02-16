<?php

namespace ForumBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


//class ForumController extends Controller
//{
//    /**
//     * @Route("/forum", name="wine_forum")
//     * @return Response
//     */
//    public function forumIndex()
//    {
//        return $this->render('/forum/index.html.twig');
//    }
//    /**
//     * @Route("/forum/new", name="wine_post")
//     * @param Request $request
//     * @return Response
//     */
//    public function forumShow(Request $request)
//    {
////        $post = new Post();
//        $form = $this->createForm(new PostForm());
//
//        $form->handleRequest($request);
//
//
//        return $this->render('/forum/post.html.twig', array(
//            'form' => $form->createView(),
//        ));
//    }
//
//
//}