<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Local;
use CB\InicioBundle\Form\LocalType;

/**
 * Local controller.
 *
 * @Route("/local")
 */
class LocalController extends Controller
{

    /**
     * Lists all Local entities.
     *
     * @Route("/", name="local")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Local')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Local entity.
     *
     * @Route("/", name="local_create")
     * @Method("POST")
     * @Template("InicioBundle:Local:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Local();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('local_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Local entity.
    *
    * @param Local $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Local $entity)
    {
        $form = $this->createForm(new LocalType(), $entity, array(
            'action' => $this->generateUrl('local_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Local entity.
     *
     * @Route("/new", name="local_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Local();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Local entity.
     *
     * @Route("/{id}", name="local_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Local')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Local entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Local entity.
     *
     * @Route("/{id}/edit", name="local_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Local')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Local entity.');
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
    * Creates a form to edit a Local entity.
    *
    * @param Local $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Local $entity)
    {
        $form = $this->createForm(new LocalType(), $entity, array(
            'action' => $this->generateUrl('local_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Local entity.
     *
     * @Route("/{id}", name="local_update")
     * @Method("PUT")
     * @Template("InicioBundle:Local:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Local')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Local entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('local_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Local entity.
     *
     * @Route("/{id}", name="local_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Local')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Local entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('local'));
    }

    /**
     * Creates a form to delete a Local entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('local_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
