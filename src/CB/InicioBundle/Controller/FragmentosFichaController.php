<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\FragmentosFicha;
use CB\InicioBundle\Form\FragmentosFichaType;

/**
 * FragmentosFicha controller.
 *
 * @Route("/fragmentosficha")
 */
class FragmentosFichaController extends Controller
{

    /**
     * Lists all FragmentosFicha entities.
     *
     * @Route("/", name="fragmentosficha")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:FragmentosFicha')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new FragmentosFicha entity.
     *
     * @Route("/", name="fragmentosficha_create")
     * @Method("POST")
     * @Template("InicioBundle:FragmentosFicha:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new FragmentosFicha();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fragmentosficha_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a FragmentosFicha entity.
    *
    * @param FragmentosFicha $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(FragmentosFicha $entity)
    {
        $form = $this->createForm(new FragmentosFichaType(), $entity, array(
            'action' => $this->generateUrl('fragmentosficha_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new FragmentosFicha entity.
     *
     * @Route("/new", name="fragmentosficha_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new FragmentosFicha();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a FragmentosFicha entity.
     *
     * @Route("/{id}", name="fragmentosficha_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:FragmentosFicha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FragmentosFicha entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing FragmentosFicha entity.
     *
     * @Route("/{id}/edit", name="fragmentosficha_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:FragmentosFicha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FragmentosFicha entity.');
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
    * Creates a form to edit a FragmentosFicha entity.
    *
    * @param FragmentosFicha $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(FragmentosFicha $entity)
    {
        $form = $this->createForm(new FragmentosFichaType(), $entity, array(
            'action' => $this->generateUrl('fragmentosficha_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing FragmentosFicha entity.
     *
     * @Route("/{id}", name="fragmentosficha_update")
     * @Method("PUT")
     * @Template("InicioBundle:FragmentosFicha:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:FragmentosFicha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FragmentosFicha entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fragmentosficha_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a FragmentosFicha entity.
     *
     * @Route("/{id}", name="fragmentosficha_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:FragmentosFicha')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FragmentosFicha entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fragmentosficha'));
    }

    /**
     * Creates a form to delete a FragmentosFicha entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fragmentosficha_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
