<?php

namespace AppBundle\Controller;

use AppBundle\Form\PostForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Wine;
use AppBundle\Form\WineType;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/admin")
     */
    public function defaultAction()
    {
        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/admin/forum", name="wine_forum")
     * @return Response
     */
    public function forumIndex()
    {
        return $this->render('/forum/index.html.twig');
    }
    /**
     * @Route("/admin/forum/new", name="wine_forum_article")
     * @param Request $request
     * @return Response
     */
    public function forumShow(Request $request)
    {
        $form = $this->createForm(new PostForm());

        $form->handleRequest($request);

        return $this->render('/forum/post.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/country/{country}/color/{color}", defaults={"country" = "all", "color" = "all"}, name="admin")
     * @param Request $request
     * @param $country
     * @param $color
     * @return Response
     */
    public function indexAction(Request $request, $country, $color)
    {
        $paginator  = $this->get('knp_paginator');
        $query = $this->wineFiltering($country, $color);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            8 /*limit per page*/
        );

        return $this->render('admin/index.html.twig', [
           'pagination' => $pagination,
           'countries' => $this->getDoctrine()->getRepository('AppBundle:Country')->findBy(
               [], [ 'name' => 'ASC' ]
           ),
            'country' => $country, // country id passed from select option
            'color' => $color,
        ]);
    }

    /**
     * Creates a new Wine entity.
     *
     * @Route("/admin/create", name="admin_create")
     * @param Request $request
     * @return Response
     */

    public function createAction(Request $request)
    {
        $wine = new Wine();
        $form = $this->createForm(new WineType(), $wine);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($wine);
            $em->flush();

            $this->addFlash('notice','Wine successfully added');

            return $this->redirectToRoute('admin');

        }

        return $this->render('/admin/default.html.twig', array(
            'form' => $form->createView(),
            ));

    }

    /**
     * Edit action
     *
     * @Route("/admin/edit/{id}", name="admin_edit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $wine = $em->getRepository('AppBundle:Wine')->find($id);

        if(!$wine){
            throw $this->createNotFoundException(
                'No wine found' .$id
            );
        }

        $form = $this->createForm(new WineType(true), $wine);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice','Wine successfully updated');

            return $this->redirectToRoute('admin');
        }

        return $this->render('/admin/default.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/view/{id}", name="admin_view")
     * @param $id
     * @return Response
     */
    public function viewAction($id)
    {
        $wine = $this->getDoctrine()->getRepository('AppBundle:Wine')->find($id);

        if (!$wine) {
            throw $this->createNotFoundException(
                'No wine found for id ' . $id
            );
        }

        return $this->render('admin/view.html.twig', [
            'wine' => $wine,
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="admin_delete")
     */
    public function deleteAction($id)
    {
        $em   = $this->getDoctrine()->getManager();
        $wine = $em->getRepository('AppBundle:Wine')->find($id);

        if(!$wine){
            throw $this->createNotFoundException(
                'No wine found' .$id
            );
        }
        $em->remove($wine);
        $em->flush();
        $this->get('session')->getFlashBag()->add('notice','Wine successfully deleted');

        return $this->redirectToRoute('admin');

    }

    /**
     * Filter wine sql
     *
     * @param string $country
     * @param string|int $color
     */
    private function  wineFiltering($country, $color)
    {
        $em    = $this->getDoctrine()->getManager();
        $countryCondition = '';
        $countryObject = null;

        if ($country != 'all') {
            $countryObject = $this->getDoctrine()->getRepository('AppBundle:Country')->find($country);
            if (!$countryObject) {
                $this->addFlash('Warning', 'No wine for this country');

            } else {
                $countryCondition = '
                    JOIN w.region r
                    WHERE r.country = :country
                ';
            }
        }

        $colorCondition = '';

        if ($color != 'all') {
            $wineObject = $this->getDoctrine()->getRepository('AppBundle:Wine')->findBy(array(
                'color' => $color
            ));
            if (!$wineObject) {
                $this->addFlash('Warning', 'There is no wine for this color');
            } else {
                if ($countryCondition) {
                    $colorCondition = ' AND w.color = :color ';
                } else {
                    $colorCondition = ' WHERE w.color = :color ';
                }
            }
        }

        $dql   = "
          SELECT w
          FROM AppBundle:Wine w
          $countryCondition
          $colorCondition
          order by w.id ASC
        ";

        $query = $em->createQuery($dql);

        if ($countryCondition) {
            $query->setParameter('country', $countryObject);
        }

        if ($colorCondition){
            $query->setParameter('color', $color);
        }

        return $query;
    }
}