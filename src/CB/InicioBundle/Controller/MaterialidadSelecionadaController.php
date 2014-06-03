<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\MaterialidadSelecionada;
use CB\InicioBundle\Form\MaterialidadSelecionadaType;

/**
 * MaterialidadSelecionada controller.
 *
 * @Route("/materialidadselecionada")
 */
class MaterialidadSelecionadaController extends Controller
{

    /**
     * Lists all MaterialidadSelecionada entities.
     *
     * @Route("/", name="materialidadselecionada")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:MaterialidadSelecionada')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MaterialidadSelecionada entity.
     *
     * @Route("/", name="materialidadselecionada_create")
     * @Method("POST")
     * @Template("InicioBundle:MaterialidadSelecionada:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MaterialidadSelecionada();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materialidadselecionada_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a MaterialidadSelecionada entity.
    *
    * @param MaterialidadSelecionada $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(MaterialidadSelecionada $entity)
    {
        $form = $this->createForm(new MaterialidadSelecionadaType(), $entity, array(
            'action' => $this->generateUrl('materialidadselecionada_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MaterialidadSelecionada entity.
     *
     * @Route("/new", name="materialidadselecionada_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MaterialidadSelecionada();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MaterialidadSelecionada entity.
     *
     * @Route("/{id}", name="materialidadselecionada_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:MaterialidadSelecionada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialidadSelecionada entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MaterialidadSelecionada entity.
     *
     * @Route("/{id}/edit", name="materialidadselecionada_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:MaterialidadSelecionada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialidadSelecionada entity.');
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
    * Creates a form to edit a MaterialidadSelecionada entity.
    *
    * @param MaterialidadSelecionada $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MaterialidadSelecionada $entity)
    {
        $form = $this->createForm(new MaterialidadSelecionadaType(), $entity, array(
            'action' => $this->generateUrl('materialidadselecionada_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MaterialidadSelecionada entity.
     *
     * @Route("/{id}", name="materialidadselecionada_update")
     * @Method("PUT")
     * @Template("InicioBundle:MaterialidadSelecionada:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:MaterialidadSelecionada')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialidadSelecionada entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materialidadselecionada_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MaterialidadSelecionada entity.
     *
     * @Route("/{id}", name="materialidadselecionada_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:MaterialidadSelecionada')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MaterialidadSelecionada entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('materialidadselecionada'));
    }

    /**
     * Creates a form to delete a MaterialidadSelecionada entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('materialidadselecionada_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
