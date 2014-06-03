<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Maps;
use CB\InicioBundle\Form\MapsType;

/**
 * Maps controller.
 *
 * @Route("/maps")
 */
class MapsController extends Controller
{

    /**
     * Lists all Maps entities.
     *
     * @Route("/", name="maps")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Maps')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Maps entity.
     *
     * @Route("/", name="maps_create")
     * @Method("POST")
     * @Template("InicioBundle:Maps:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Maps();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('maps_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Maps entity.
    *
    * @param Maps $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Maps $entity)
    {
        $form = $this->createForm(new MapsType(), $entity, array(
            'action' => $this->generateUrl('maps_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Maps entity.
     *
     * @Route("/new", name="maps_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Maps();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Maps entity.
     *
     * @Route("/{id}", name="maps_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Maps')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Maps entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Maps entity.
     *
     * @Route("/{id}/edit", name="maps_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Maps')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Maps entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Maps entity.
    *
    * @param Maps $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Maps $entity)
    {
        $form = $this->createForm(new MapsType(), $entity, array(
            'action' => $this->generateUrl('maps_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Maps entity.
     *
     * @Route("/{id}", name="maps_update")
     * @Method("PUT")
     * @Template("InicioBundle:Maps:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Maps')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Maps entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('maps_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Maps entity.
     *
     * @Route("/{id}", name="maps_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Maps')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Maps entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('maps'));
    }

    /**
     * Creates a form to delete a Maps entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('maps_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
