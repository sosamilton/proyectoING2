<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Ciudad;
use CB\InicioBundle\Form\CiudadType;

/**
 * Ciudad controller.
 *
 * @Route("/ciudad")
 */
class CiudadController extends Controller
{

    /**
     * Lists all Ciudad entities.
     *
     * @Route("/", name="ciudad")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Ciudad')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ciudad entity.
     *
     * @Route("/", name="ciudad_create")
     * @Method("POST")
     * @Template("InicioBundle:Ciudad:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ciudad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ciudad_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Ciudad entity.
    *
    * @param Ciudad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Ciudad $entity)
    {
        $form = $this->createForm(new CiudadType(), $entity, array(
            'action' => $this->generateUrl('ciudad_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ciudad entity.
     *
     * @Route("/new", name="ciudad_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ciudad();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ciudad entity.
     *
     * @Route("/{id}", name="ciudad_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ciudad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ciudad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ciudad entity.
     *
     * @Route("/{id}/edit", name="ciudad_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ciudad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ciudad entity.');
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
    * Creates a form to edit a Ciudad entity.
    *
    * @param Ciudad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ciudad $entity)
    {
        $form = $this->createForm(new CiudadType(), $entity, array(
            'action' => $this->generateUrl('ciudad_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ciudad entity.
     *
     * @Route("/{id}", name="ciudad_update")
     * @Method("PUT")
     * @Template("InicioBundle:Ciudad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ciudad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ciudad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ciudad_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ciudad entity.
     *
     * @Route("/{id}", name="ciudad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Ciudad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ciudad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ciudad'));
    }

    /**
     * Creates a form to delete a Ciudad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ciudad_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
