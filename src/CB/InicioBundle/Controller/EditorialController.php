<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Editorial;
use CB\InicioBundle\Form\EditorialType;

/**
 * Editorial controller.
 *
 * @Route("/editorial")
 */
class EditorialController extends Controller
{

    /**
     * Lists all Editorial entities.
     *
     * @Route("/", name="editorial")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Editorial')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Editorial entity.
     *
     * @Route("/", name="editorial_create")
     * @Method("POST")
     * @Template("InicioBundle:Editorial:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Editorial();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('editorial_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Editorial entity.
    *
    * @param Editorial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Editorial $entity)
    {
        $form = $this->createForm(new EditorialType(), $entity, array(
            'action' => $this->generateUrl('editorial_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Editorial entity.
     *
     * @Route("/new", name="editorial_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Editorial();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Editorial entity.
     *
     * @Route("/{id}", name="editorial_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Editorial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Editorial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Editorial entity.
     *
     * @Route("/{id}/edit", name="editorial_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Editorial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Editorial entity.');
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
    * Creates a form to edit a Editorial entity.
    *
    * @param Editorial $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Editorial $entity)
    {
        $form = $this->createForm(new EditorialType(), $entity, array(
            'action' => $this->generateUrl('editorial_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Editorial entity.
     *
     * @Route("/{id}", name="editorial_update")
     * @Method("PUT")
     * @Template("InicioBundle:Editorial:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Editorial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Editorial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('editorial'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Editorial entity.
     *
     * @Route("/{id}", name="editorial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Editorial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Editorial entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('editorial'));
    }

    /**
     * Creates a form to delete a Editorial entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('editorial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
