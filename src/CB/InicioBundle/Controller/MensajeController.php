<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Mensaje;
use CB\InicioBundle\Form\MensajeType;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Mensaje controller.
 *
 * @Route("/admin/mensaje")
 */
class MensajeController extends Controller
{

    /**
     * Lists all Mensaje entities.
     *
     * @Route("/", name="mensaje")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Mensaje')->findAll();

        return array(
            'entities' => $entities,
            'ruta' => 'mensaje',
            'title' => 'Mensajes'
        );
    }
    /**
     * Creates a new Mensaje entity.
     *
     * @Route("/", name="mensaje_create")
     * @Method("POST")
     * @Template("InicioBundle:Mensaje:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Mensaje();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
                $usr= $this->get('security.context')->getToken()->getUser();
                $entity->setUsuario($usr);
            }
        
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('contacto', true));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Mensaje entity.
     *
     * @param Mensaje $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Mensaje $entity)
    {
        $form = $this->createForm(new MensajeType(), $entity, array(
            'action' => $this->generateUrl('mensaje_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Mensaje entity.
     *
     * @Route("/new", name="mensaje_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mensaje();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Mensaje entity.
     *
     * @Route("/{id}", name="mensaje_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Mensaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mensaje entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'ruta' => 'mensaje',
        );
    }

    /**
     * Displays a form to edit an existing Mensaje entity.
     *
     * @Route("/{id}/edit", name="mensaje_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Mensaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mensaje entity.');
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
    * Creates a form to edit a Mensaje entity.
    *
    * @param Mensaje $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mensaje $entity)
    {
        $form = $this->createForm(new MensajeType(), $entity, array(
            'action' => $this->generateUrl('mensaje_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Mensaje entity.
     *
     * @Route("/{id}", name="mensaje_update")
     * @Method("PUT")
     * @Template("InicioBundle:Mensaje:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Mensaje')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mensaje entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mensaje_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Mensaje entity.
     *
     * @Route("/{id}", name="mensaje_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Mensaje')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mensaje entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mensaje'));
    }

    /**
     * Creates a form to delete a Mensaje entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mensaje_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function marcarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('InicioBundle:Mensaje')->find($id);
        $leido= $entity->getLeido();
        $entity->setLeido(!$leido);
        $em->flush();
        return $this->redirect($this->generateUrl('mensaje'));
    }
}
