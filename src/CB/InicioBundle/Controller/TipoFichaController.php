<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\TipoFicha;
use CB\InicioBundle\Form\TipoFichaType;

/**
 * TipoFicha controller.
 *
 * @Route("/tipoficha")
 */
class TipoFichaController extends Controller
{

    /**
     * Lists all TipoFicha entities.
     *
     * @Route("/", name="tipoficha")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:TipoFicha')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TipoFicha entity.
     *
     * @Route("/", name="tipoficha_create")
     * @Method("POST")
     * @Template("InicioBundle:TipoFicha:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TipoFicha();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tipoficha_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a TipoFicha entity.
    *
    * @param TipoFicha $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TipoFicha $entity)
    {
        $form = $this->createForm(new TipoFichaType(), $entity, array(
            'action' => $this->generateUrl('tipoficha_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TipoFicha entity.
     *
     * @Route("/new", name="tipoficha_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TipoFicha();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TipoFicha entity.
     *
     * @Route("/{id}", name="tipoficha_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:TipoFicha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoFicha entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TipoFicha entity.
     *
     * @Route("/{id}/edit", name="tipoficha_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:TipoFicha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoFicha entity.');
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
    * Creates a form to edit a TipoFicha entity.
    *
    * @param TipoFicha $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TipoFicha $entity)
    {
        $form = $this->createForm(new TipoFichaType(), $entity, array(
            'action' => $this->generateUrl('tipoficha_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TipoFicha entity.
     *
     * @Route("/{id}", name="tipoficha_update")
     * @Method("PUT")
     * @Template("InicioBundle:TipoFicha:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:TipoFicha')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TipoFicha entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tipoficha_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TipoFicha entity.
     *
     * @Route("/{id}", name="tipoficha_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:TipoFicha')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TipoFicha entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tipoficha'));
    }

    /**
     * Creates a form to delete a TipoFicha entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipoficha_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
