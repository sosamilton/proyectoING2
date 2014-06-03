<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Ubicacion;
use CB\InicioBundle\Form\UbicacionType;

/**
 * Ubicacion controller.
 *
 * @Route("/ubicacion")
 */
class UbicacionController extends Controller
{

    /**
     * Lists all Ubicacion entities.
     *
     * @Route("/", name="ubicacion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Ubicacion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ubicacion entity.
     *
     * @Route("/", name="ubicacion_create")
     * @Method("POST")
     * @Template("InicioBundle:Ubicacion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ubicacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ubicacion_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Ubicacion entity.
    *
    * @param Ubicacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Ubicacion $entity)
    {
        $form = $this->createForm(new UbicacionType(), $entity, array(
            'action' => $this->generateUrl('ubicacion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ubicacion entity.
     *
     * @Route("/new", name="ubicacion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ubicacion();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ubicacion entity.
     *
     * @Route("/{id}", name="ubicacion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ubicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ubicacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ubicacion entity.
     *
     * @Route("/{id}/edit", name="ubicacion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ubicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ubicacion entity.');
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
    * Creates a form to edit a Ubicacion entity.
    *
    * @param Ubicacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ubicacion $entity)
    {
        $form = $this->createForm(new UbicacionType(), $entity, array(
            'action' => $this->generateUrl('ubicacion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ubicacion entity.
     *
     * @Route("/{id}", name="ubicacion_update")
     * @Method("PUT")
     * @Template("InicioBundle:Ubicacion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ubicacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ubicacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ubicacion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ubicacion entity.
     *
     * @Route("/{id}", name="ubicacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Ubicacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ubicacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ubicacion'));
    }

    /**
     * Creates a form to delete a Ubicacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ubicacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
