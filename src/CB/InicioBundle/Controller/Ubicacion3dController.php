<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Ubicacion3d;
use CB\InicioBundle\Form\Ubicacion3dType;

/**
 * Ubicacion3d controller.
 *
 * @Route("/ubicacion3d")
 */
class Ubicacion3dController extends Controller
{

    /**
     * Lists all Ubicacion3d entities.
     *
     * @Route("/", name="ubicacion3d")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Ubicacion3d')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ubicacion3d entity.
     *
     * @Route("/", name="ubicacion3d_create")
     * @Method("POST")
     * @Template("InicioBundle:Ubicacion3d:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Ubicacion3d();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ubicacion3d_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Ubicacion3d entity.
    *
    * @param Ubicacion3d $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Ubicacion3d $entity)
    {
        $form = $this->createForm(new Ubicacion3dType(), $entity, array(
            'action' => $this->generateUrl('ubicacion3d_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Ubicacion3d entity.
     *
     * @Route("/new", name="ubicacion3d_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ubicacion3d();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ubicacion3d entity.
     *
     * @Route("/{id}", name="ubicacion3d_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ubicacion3d')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ubicacion3d entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ubicacion3d entity.
     *
     * @Route("/{id}/edit", name="ubicacion3d_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ubicacion3d')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ubicacion3d entity.');
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
    * Creates a form to edit a Ubicacion3d entity.
    *
    * @param Ubicacion3d $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ubicacion3d $entity)
    {
        $form = $this->createForm(new Ubicacion3dType(), $entity, array(
            'action' => $this->generateUrl('ubicacion3d_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Ubicacion3d entity.
     *
     * @Route("/{id}", name="ubicacion3d_update")
     * @Method("PUT")
     * @Template("InicioBundle:Ubicacion3d:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Ubicacion3d')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ubicacion3d entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ubicacion3d_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ubicacion3d entity.
     *
     * @Route("/{id}", name="ubicacion3d_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Ubicacion3d')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ubicacion3d entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ubicacion3d'));
    }

    /**
     * Creates a form to delete a Ubicacion3d entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ubicacion3d_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
