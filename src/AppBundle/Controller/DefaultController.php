<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{


    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('public/index.html.twig');
    }

    /**
     * @Route("/list/country/{country}/color/{color}", defaults={"country" = "all", "color" = "all"}, name="wine_list")
     *
     * @param Request $request
     * @param $country
     * @param $color
     * @return Response
     */
    public function listAction(Request $request, $country, $color)
    {
        $paginator  = $this->get('knp_paginator');
        $query = $this->wineFiltering($country, $color);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            5 /*limit per page*/
        );

        return $this->render('public/list.html.twig', [
            'pagination' => $pagination,
            'countries' => $this->getDoctrine()->getRepository('AppBundle:Country')->findBy(
                [], [ 'name' => 'ASC' ]
            ),
            'country' => $country, // country id passed from select option
            'color' => $color,
        ]);
    }

    /**
     * @Route("/view/{id}", name="wine_view")
     *
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

        return $this->render('public/view.html.twig', [
            'wine' => $wine,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     *
     * @return Response
     */
    public function contactAction()
    {
        return $this->render('public/contact.html.twig');
    }

    /**
     * @Route("/about", name="about")
     *
     * @return Response
     */
    public function aboutAction()
    {
        return $this->render('public/about.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blogAction()
    {
        return $this->render('public/blog.html.twig');
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
