<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\PatologiaGrupo;
use CB\InicioBundle\Form\PatologiaGrupoType;

/**
 * PatologiaGrupo controller.
 *
 * @Route("/patologiagrupo")
 */
class PatologiaGrupoController extends Controller
{

    /**
     * Lists all PatologiaGrupo entities.
     *
     * @Route("/", name="patologiagrupo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:PatologiaGrupo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PatologiaGrupo entity.
     *
     * @Route("/", name="patologiagrupo_create")
     * @Method("POST")
     * @Template("InicioBundle:PatologiaGrupo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PatologiaGrupo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('patologiagrupo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PatologiaGrupo entity.
    *
    * @param PatologiaGrupo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PatologiaGrupo $entity)
    {
        $form = $this->createForm(new PatologiaGrupoType(), $entity, array(
            'action' => $this->generateUrl('patologiagrupo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PatologiaGrupo entity.
     *
     * @Route("/new", name="patologiagrupo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PatologiaGrupo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PatologiaGrupo entity.
     *
     * @Route("/{id}", name="patologiagrupo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiaGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiaGrupo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PatologiaGrupo entity.
     *
     * @Route("/{id}/edit", name="patologiagrupo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiaGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiaGrupo entity.');
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
    * Creates a form to edit a PatologiaGrupo entity.
    *
    * @param PatologiaGrupo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PatologiaGrupo $entity)
    {
        $form = $this->createForm(new PatologiaGrupoType(), $entity, array(
            'action' => $this->generateUrl('patologiagrupo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PatologiaGrupo entity.
     *
     * @Route("/{id}", name="patologiagrupo_update")
     * @Method("PUT")
     * @Template("InicioBundle:PatologiaGrupo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:PatologiaGrupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PatologiaGrupo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('patologiagrupo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PatologiaGrupo entity.
     *
     * @Route("/{id}", name="patologiagrupo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:PatologiaGrupo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PatologiaGrupo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('patologiagrupo'));
    }

    /**
     * Creates a form to delete a PatologiaGrupo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patologiagrupo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
