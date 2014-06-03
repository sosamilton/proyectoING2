<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Materialidad;
use CB\InicioBundle\Form\MaterialidadType;

/**
 * Materialidad controller.
 *
 * @Route("/materialidad")
 */
class MaterialidadController extends Controller
{

    /**
     * Lists all Materialidad entities.
     *
     * @Route("/", name="materialidad")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Materialidad')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Materialidad entity.
     *
     * @Route("/", name="materialidad_create")
     * @Method("POST")
     * @Template("InicioBundle:Materialidad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Materialidad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materialidad_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Materialidad entity.
    *
    * @param Materialidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Materialidad $entity)
    {
        $form = $this->createForm(new MaterialidadType(), $entity, array(
            'action' => $this->generateUrl('materialidad_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Materialidad entity.
     *
     * @Route("/new", name="materialidad_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Materialidad();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Materialidad entity.
     *
     * @Route("/{id}", name="materialidad_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Materialidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Materialidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Materialidad entity.
     *
     * @Route("/{id}/edit", name="materialidad_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Materialidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Materialidad entity.');
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
    * Creates a form to edit a Materialidad entity.
    *
    * @param Materialidad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Materialidad $entity)
    {
        $form = $this->createForm(new MaterialidadType(), $entity, array(
            'action' => $this->generateUrl('materialidad_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Materialidad entity.
     *
     * @Route("/{id}", name="materialidad_update")
     * @Method("PUT")
     * @Template("InicioBundle:Materialidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Materialidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Materialidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('materialidad_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Materialidad entity.
     *
     * @Route("/{id}", name="materialidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Materialidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Materialidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('materialidad'));
    }

    /**
     * Creates a form to delete a Materialidad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('materialidad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
