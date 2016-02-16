<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Wine;
use AppBundle\Form\WineType;

/**
 * Wine controller.
 *
 * @Route("/wine")
 */
class WineController extends Controller
{
    /**
     * Lists all Wine entities.
     *
     * @Route("/", name="wine_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wines = $em->getRepository('AppBundle:Wine')->findAll();

        return $this->render('wine/index.html.twig', array(
            'wines' => $wines,
        ));
    }

    /**
     * Creates a new Wine entity.
     *
     * @Route("/new", name="wine_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $wine = new Wine();
        $form = $this->createForm('AppBundle\Form\WineType', $wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wine);
            $em->flush();

            return $this->redirectToRoute('wine_show', array('id' => $wine->getId()));
        }

        return $this->render('wine/new.html.twig', array(
            'wine' => $wine,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Wine entity.
     *
     * @Route("/{id}", name="wine_show")
     * @Method("GET")
     */
    public function showAction(Wine $wine)
    {
        $deleteForm = $this->createDeleteForm($wine);

        return $this->render('wine/show.html.twig', array(
            'wine' => $wine,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Wine entity.
     *
     * @Route("/{id}/edit", name="wine_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Wine $wine)
    {
        $deleteForm = $this->createDeleteForm($wine);
        $editForm = $this->createForm('AppBundle\Form\WineType', $wine);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wine);
            $em->flush();

            return $this->redirectToRoute('wine_edit', array('id' => $wine->getId()));
        }

        return $this->render('wine/edit.html.twig', array(
            'wine' => $wine,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Wine entity.
     *
     * @Route("/{id}", name="wine_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Wine $wine)
    {
        $form = $this->createDeleteForm($wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wine);
            $em->flush();
        }

        return $this->redirectToRoute('wine_index');
    }

    /**
     * Creates a form to delete a Wine entity.
     *
     * @param Wine $wine The Wine entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Wine $wine)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('wine_delete', array('id' => $wine->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
