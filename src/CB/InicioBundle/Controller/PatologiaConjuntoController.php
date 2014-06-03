<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\PatologiaConjunto;
use CB\InicioBundle\Form\PatologiaConjuntoType;

/**
 * PatologiaConjunto controller.
 *
 * @Route("/patologiaconjunto")
 */
class PatologiaConjuntoController extends Controller
{

    /**
     * Lists all PatologiaConjunto entities.
     *
     * @Route("/", name="patologiaconjunto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:PatologiaConjunto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PatologiaConjunto entity.
     *
     * @Route("/", name="patologiaconjunto_create")
     * @Method("POST")
     * @Template("InicioBundle:PatologiaConjunto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PatologiaConjunto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('patologiaconjunto_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PatologiaConjunto entity.
    *
    * @param PatologiaConjunto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PatologiaConjunto $entity)
    {
        $form = $this->createForm(new PatologiaConjuntoType(), $entity, array(
            'action' => $this->generateUrl('patologiaconjunto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PatologiaConjunto entity.
     *
     * @Route("/new", name="patologiaconjunto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PatologiaConjunto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PatologiaConjunto entity.
     *
     * @Route("/{id}", name="patologiaconjunto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiaConjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiaConjunto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PatologiaConjunto entity.
     *
     * @Route("/{id}/edit", name="patologiaconjunto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiaConjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiaConjunto entity.');
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
    * Creates a form to edit a PatologiaConjunto entity.
    *
    * @param PatologiaConjunto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PatologiaConjunto $entity)
    {
        $form = $this->createForm(new PatologiaConjuntoType(), $entity, array(
            'action' => $this->generateUrl('patologiaconjunto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PatologiaConjunto entity.
     *
     * @Route("/{id}", name="patologiaconjunto_update")
     * @Method("PUT")
     * @Template("InicioBundle:PatologiaConjunto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiaConjunto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiaConjunto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('patologiaconjunto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PatologiaConjunto entity.
     *
     * @Route("/{id}", name="patologiaconjunto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:PatologiaConjunto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PatologiaConjunto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('patologiaconjunto'));
    }

    /**
     * Creates a form to delete a PatologiaConjunto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patologiaconjunto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
