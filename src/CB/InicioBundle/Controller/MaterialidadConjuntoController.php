<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\MaterialidadConjunto;
use CB\InicioBundle\Form\MaterialidadConjuntoType;

/**
 * MaterialidadConjunto controller.
 *
 * @Route("/materialidadconjunto")
 */
class MaterialidadConjuntoController extends Controller
{

    /**
     * Lists all MaterialidadConjunto entities.
     *
     * @Route("/", name="materialidadconjunto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:MaterialidadConjunto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MaterialidadConjunto entity.
     *
     * @Route("/", name="materialidadconjunto_create")
     * @Method("POST")
     * @Template("InicioBundle:MaterialidadConjunto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MaterialidadConjunto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materialidadconjunto_show', array('id' => $entity->getId())));
        }
        
        

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a MaterialidadConjunto entity.
    *
    * @param MaterialidadConjunto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(MaterialidadConjunto $entity)
    {
        $form = $this->createForm(new MaterialidadConjuntoType(), $entity, array(
            'action' => $this->generateUrl('materialidadconjunto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MaterialidadConjunto entity.
     *
     * @Route("/new", name="materialidadconjunto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MaterialidadConjunto();
        $form   = $this->createCreateForm($entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MaterialidadConjunto entity.
     *
     * @Route("/{id}", name="materialidadconjunto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:MaterialidadConjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialidadConjunto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MaterialidadConjunto entity.
     *
     * @Route("/{id}/edit", name="materialidadconjunto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:MaterialidadConjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialidadConjunto entity.');
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
    * Creates a form to edit a MaterialidadConjunto entity.
    *
    * @param MaterialidadConjunto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MaterialidadConjunto $entity)
    {
        $form = $this->createForm(new MaterialidadConjuntoType(), $entity, array(
            'action' => $this->generateUrl('materialidadconjunto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MaterialidadConjunto entity.
     *
     * @Route("/{id}", name="materialidadconjunto_update")
     * @Method("PUT")
     * @Template("InicioBundle:MaterialidadConjunto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:MaterialidadConjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MaterialidadConjunto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materialidadconjunto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MaterialidadConjunto entity.
     *
     * @Route("/{id}", name="materialidadconjunto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:MaterialidadConjunto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MaterialidadConjunto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('materialidadconjunto'));
    }

    /**
     * Creates a form to delete a MaterialidadConjunto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('materialidadconjunto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
