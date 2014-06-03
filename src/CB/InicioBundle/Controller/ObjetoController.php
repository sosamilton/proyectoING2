<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Objeto;
use CB\InicioBundle\Form\ObjetoType;

/**
 * Objeto controller.
 *
 * @Route("/objeto")
 */
class ObjetoController extends Controller
{

    /**
     * Lists all Objeto entities.
     *
     * @Route("/", name="objeto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Objeto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Objeto entity.
     *
     * @Route("/", name="objeto_create")
     * @Method("POST")
     * @Template("InicioBundle:Objeto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Objeto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('objeto_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Objeto entity.
    *
    * @param Objeto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Objeto $entity)
    {
        $form = $this->createForm(new ObjetoType(), $entity, array(
            'action' => $this->generateUrl('objeto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Objeto entity.
     *
     * @Route("/new", name="objeto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Objeto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Objeto entity.
     *
     * @Route("/{id}", name="objeto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Objeto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Objeto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Objeto entity.
     *
     * @Route("/{id}/edit", name="objeto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Objeto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Objeto entity.');
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
    * Creates a form to edit a Objeto entity.
    *
    * @param Objeto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Objeto $entity)
    {
        $form = $this->createForm(new ObjetoType(), $entity, array(
            'action' => $this->generateUrl('objeto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Objeto entity.
     *
     * @Route("/{id}", name="objeto_update")
     * @Method("PUT")
     * @Template("InicioBundle:Objeto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Objeto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Objeto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('objeto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Objeto entity.
     *
     * @Route("/{id}", name="objeto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Objeto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Objeto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('objeto'));
    }

    /**
     * Creates a form to delete a Objeto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('objeto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
