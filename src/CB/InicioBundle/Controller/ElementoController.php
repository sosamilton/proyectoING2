<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Elemento;
use CB\InicioBundle\Form\ElementoType;

/**
 * Elemento controller.
 *
 * @Route("/elemento")
 */
class ElementoController extends Controller
{

    /**
     * Lists all Elemento entities.
     *
     * @Route("/", name="elemento")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Elemento')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Elemento entity.
     *
     * @Route("/", name="elemento_create")
     * @Method("POST")
     * @Template("InicioBundle:Elemento:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Elemento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('elemento_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Elemento entity.
     *
     * @param Elemento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Elemento $entity)
    {
        $form = $this->createForm(new ElementoType(), $entity, array(
            'action' => $this->generateUrl('elemento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Elemento entity.
     *
     * @Route("/new", name="elemento_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Elemento();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Elemento entity.
     *
     * @Route("/{id}", name="elemento_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Elemento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Elemento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Elemento entity.
     *
     * @Route("/{id}/edit", name="elemento_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Elemento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Elemento entity.');
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
    * Creates a form to edit a Elemento entity.
    *
    * @param Elemento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Elemento $entity)
    {
        $form = $this->createForm(new ElementoType(), $entity, array(
            'action' => $this->generateUrl('elemento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Elemento entity.
     *
     * @Route("/{id}", name="elemento_update")
     * @Method("PUT")
     * @Template("InicioBundle:Elemento:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Elemento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Elemento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('elemento_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Elemento entity.
     *
     * @Route("/{id}", name="elemento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Elemento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Elemento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('elemento'));
    }

    /**
     * Creates a form to delete a Elemento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('elemento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
