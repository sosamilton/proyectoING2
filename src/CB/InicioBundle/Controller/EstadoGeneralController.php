<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\EstadoGeneral;
use CB\InicioBundle\Form\EstadoGeneralType;

/**
 * EstadoGeneral controller.
 *
 * @Route("/estadogeneral")
 */
class EstadoGeneralController extends Controller
{

    /**
     * Lists all EstadoGeneral entities.
     *
     * @Route("/", name="estadogeneral")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:EstadoGeneral')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new EstadoGeneral entity.
     *
     * @Route("/", name="estadogeneral_create")
     * @Method("POST")
     * @Template("InicioBundle:EstadoGeneral:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new EstadoGeneral();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('estadogeneral_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a EstadoGeneral entity.
    *
    * @param EstadoGeneral $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(EstadoGeneral $entity)
    {
        $form = $this->createForm(new EstadoGeneralType(), $entity, array(
            'action' => $this->generateUrl('estadogeneral_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new EstadoGeneral entity.
     *
     * @Route("/new", name="estadogeneral_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EstadoGeneral();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EstadoGeneral entity.
     *
     * @Route("/{id}", name="estadogeneral_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:EstadoGeneral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoGeneral entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EstadoGeneral entity.
     *
     * @Route("/{id}/edit", name="estadogeneral_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:EstadoGeneral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoGeneral entity.');
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
    * Creates a form to edit a EstadoGeneral entity.
    *
    * @param EstadoGeneral $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EstadoGeneral $entity)
    {
        $form = $this->createForm(new EstadoGeneralType(), $entity, array(
            'action' => $this->generateUrl('estadogeneral_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EstadoGeneral entity.
     *
     * @Route("/{id}", name="estadogeneral_update")
     * @Method("PUT")
     * @Template("InicioBundle:EstadoGeneral:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:EstadoGeneral')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EstadoGeneral entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('estadogeneral_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a EstadoGeneral entity.
     *
     * @Route("/{id}", name="estadogeneral_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:EstadoGeneral')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EstadoGeneral entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('estadogeneral'));
    }

    /**
     * Creates a form to delete a EstadoGeneral entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estadogeneral_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
