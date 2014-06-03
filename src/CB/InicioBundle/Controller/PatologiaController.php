<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Patologia;
use CB\InicioBundle\Form\PatologiaType;

/**
 * Patologia controller.
 *
 * @Route("/patologia")
 */
class PatologiaController extends Controller
{

    /**
     * Lists all Patologia entities.
     *
     * @Route("/", name="patologia")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Patologia')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Patologia entity.
     *
     * @Route("/", name="patologia_create")
     * @Method("POST")
     * @Template("InicioBundle:Patologia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Patologia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('patologia_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Patologia entity.
    *
    * @param Patologia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Patologia $entity)
    {
        $form = $this->createForm(new PatologiaType(), $entity, array(
            'action' => $this->generateUrl('patologia_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Patologia entity.
     *
     * @Route("/new", name="patologia_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Patologia();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Patologia entity.
     *
     * @Route("/{id}", name="patologia_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Patologia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patologia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Patologia entity.
     *
     * @Route("/{id}/edit", name="patologia_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Patologia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patologia entity.');
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
    * Creates a form to edit a Patologia entity.
    *
    * @param Patologia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Patologia $entity)
    {
        $form = $this->createForm(new PatologiaType(), $entity, array(
            'action' => $this->generateUrl('patologia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Patologia entity.
     *
     * @Route("/{id}", name="patologia_update")
     * @Method("PUT")
     * @Template("InicioBundle:Patologia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Patologia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patologia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('patologia_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Patologia entity.
     *
     * @Route("/{id}", name="patologia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Patologia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Patologia entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('patologia'));
    }

    /**
     * Creates a form to delete a Patologia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patologia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
