<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Identificacion;
use CB\InicioBundle\Form\IdentificacionType;

/**
 * Identificacion controller.
 *
 * @Route("/identificacion")
 */
class IdentificacionController extends Controller
{

    /**
     * Lists all Identificacion entities.
     *
     * @Route("/", name="identificacion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Identificacion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Identificacion entity.
     *
     * @Route("/", name="identificacion_create")
     * @Method("POST")
     * @Template("InicioBundle:Identificacion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Identificacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('identificacion_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Identificacion entity.
    *
    * @param Identificacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Identificacion $entity)
    {
        $form = $this->createForm(new IdentificacionType(), $entity, array(
            'action' => $this->generateUrl('identificacion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Identificacion entity.
     *
     * @Route("/new", name="identificacion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Identificacion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Identificacion entity.
     *
     * @Route("/{id}", name="identificacion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Identificacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Identificacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Identificacion entity.
     *
     * @Route("/{id}/edit", name="identificacion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Identificacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Identificacion entity.');
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
    * Creates a form to edit a Identificacion entity.
    *
    * @param Identificacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Identificacion $entity)
    {
        $form = $this->createForm(new IdentificacionType(), $entity, array(
            'action' => $this->generateUrl('identificacion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Identificacion entity.
     *
     * @Route("/{id}", name="identificacion_update")
     * @Method("PUT")
     * @Template("InicioBundle:Identificacion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Identificacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Identificacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('identificacion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Identificacion entity.
     *
     * @Route("/{id}", name="identificacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Identificacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Identificacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('identificacion'));
    }

    /**
     * Creates a form to delete a Identificacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('identificacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
