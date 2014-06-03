<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\PatologiasSeleccionadas;
use CB\InicioBundle\Form\PatologiasSeleccionadasType;

/**
 * PatologiasSeleccionadas controller.
 *
 * @Route("/patologiasseleccionadas")
 */
class PatologiasSeleccionadasController extends Controller
{

    /**
     * Lists all PatologiasSeleccionadas entities.
     *
     * @Route("/", name="patologiasseleccionadas")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:PatologiasSeleccionadas')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PatologiasSeleccionadas entity.
     *
     * @Route("/", name="patologiasseleccionadas_create")
     * @Method("POST")
     * @Template("InicioBundle:PatologiasSeleccionadas:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PatologiasSeleccionadas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('patologiasseleccionadas_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PatologiasSeleccionadas entity.
    *
    * @param PatologiasSeleccionadas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PatologiasSeleccionadas $entity)
    {
        $form = $this->createForm(new PatologiasSeleccionadasType(), $entity, array(
            'action' => $this->generateUrl('patologiasseleccionadas_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PatologiasSeleccionadas entity.
     *
     * @Route("/new", name="patologiasseleccionadas_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PatologiasSeleccionadas();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PatologiasSeleccionadas entity.
     *
     * @Route("/{id}", name="patologiasseleccionadas_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiasSeleccionadas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiasSeleccionadas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PatologiasSeleccionadas entity.
     *
     * @Route("/{id}/edit", name="patologiasseleccionadas_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiasSeleccionadas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiasSeleccionadas entity.');
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
    * Creates a form to edit a PatologiasSeleccionadas entity.
    *
    * @param PatologiasSeleccionadas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PatologiasSeleccionadas $entity)
    {
        $form = $this->createForm(new PatologiasSeleccionadasType(), $entity, array(
            'action' => $this->generateUrl('patologiasseleccionadas_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PatologiasSeleccionadas entity.
     *
     * @Route("/{id}", name="patologiasseleccionadas_update")
     * @Method("PUT")
     * @Template("InicioBundle:PatologiasSeleccionadas:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiasSeleccionadas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiasSeleccionadas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('patologiasseleccionadas_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PatologiasSeleccionadas entity.
     *
     * @Route("/{id}", name="patologiasseleccionadas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:PatologiasSeleccionadas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PatologiasSeleccionadas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('patologiasseleccionadas'));
    }

    /**
     * Creates a form to delete a PatologiasSeleccionadas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patologiasseleccionadas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
