<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Dimension;
use CB\InicioBundle\Form\DimensionType;

/**
 * Dimension controller.
 *
 * @Route("/dimension")
 */
class DimensionController extends Controller
{

    /**
     * Lists all Dimension entities.
     *
     * @Route("/", name="dimension")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Dimension')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Dimension entity.
     *
     * @Route("/", name="dimension_create")
     * @Method("POST")
     * @Template("InicioBundle:Dimension:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Dimension();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dimension_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Dimension entity.
    *
    * @param Dimension $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Dimension $entity)
    {
        $form = $this->createForm(new DimensionType(), $entity, array(
            'action' => $this->generateUrl('dimension_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Dimension entity.
     *
     * @Route("/new", name="dimension_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Dimension();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Dimension entity.
     *
     * @Route("/{id}", name="dimension_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Dimension')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Dimension entity.
     *
     * @Route("/{id}/edit", name="dimension_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Dimension')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
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
    * Creates a form to edit a Dimension entity.
    *
    * @param Dimension $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Dimension $entity)
    {
        $form = $this->createForm(new DimensionType(), $entity, array(
            'action' => $this->generateUrl('dimension_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Dimension entity.
     *
     * @Route("/{id}", name="dimension_update")
     * @Method("PUT")
     * @Template("InicioBundle:Dimension:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Dimension')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dimension_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Dimension entity.
     *
     * @Route("/{id}", name="dimension_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Dimension')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Dimension entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dimension'));
    }

    /**
     * Creates a form to delete a Dimension entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dimension_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
