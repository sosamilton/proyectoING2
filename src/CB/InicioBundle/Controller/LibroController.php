<?php

namespace CB\InicioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use CB\InicioBundle\Entity\Libro;
use CB\InicioBundle\Form\LibroType;

/**
 * Libro controller.
 *
 * @Route("/admin/libro")
 */
class LibroController extends Controller
{

    /**
     * Lists all Libro entities.
     *
     * @Route("/", name="libro")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('InicioBundle:Libro')->findAll();

        return array(
            'entities' => $entities,
            'ruta'=> "libro"
        );
    }
    /**
     * Ordenar por nombre.
     *
     * @Route("/{order}/{atributo}", name="ordenar_libro")
     * @Method("GET")
     * @Template()
     */
    public function findAllOrderedByAllAction($order, $atributo)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('InicioBundle:Libro')->findBy(array(), 
                array($atributo => $order
        ));
        
        return $this->render('InicioBundle:Libro:index.html.twig', array('entities' => $entities));
    }
    /**
     * Creates a new Libro entity.
     *
     * @Route("/", name="libro_create")
     * @Method("POST")
     * @Template("InicioBundle:Libro:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Libro();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $error = false;
        
        $isbn=$entity->getIsbn();
        $em = $this->getDoctrine()->getManager();
        $existe = $em->getRepository('InicioBundle:Libro')->findOneByIsbn($isbn);
        if ( (isset($existe)) && ($existe->getBorrado()) ){
            $existe->setBorrado(false);
            $em->persist($existe);
            $em->flush();
            return $this->redirect($this->generateUrl('libro', array('title'=>"listado de libro")));
        } else
            
        {

        if ($form->isValid()) {
            if ($_FILES["imagen"]["error"] > 0) {
                $error = "No se pudo cargar la imagen";
            }else {
                $name= $_FILES["imagen"]["name"]; 
                $type= $_FILES["imagen"]["type"];
                $size= $_FILES["imagen"]["size"];

                $tmp_name = $_FILES["imagen"]["tmp_name"];
                $type=explode ( '/', $type);
                if ($type[0] =='image') {
                    if (($type[1] =='jpeg') or ($type[1] =='png') ){
                        if ( ($size / 1024) <= 5120) {
                            $ok = move_uploaded_file($tmp_name, '../web/uploads/image/'.$entity->getIsbn().'.jpg');                      
                            if ($ok){
                               $em = $this->getDoctrine()->getManager();
                               $entity->setImagen('uploads/image/'.$entity->getIsbn().'.jpg');
                               $em->persist($entity);
                               $em->flush();
                               return $this->redirect($this->generateUrl('libro_show', array('id' => $entity->getId())));
                            }else{
                                $error = "No se pudo cargar la imagen";
                            }
                        }  else {
                            $error = "La imagen es muy grande (Tamaño máximo = 5MB)";
                        }
                    } else {
                        $error = "El formato de imagen no es soportado";
                    }
                }  else {
                   $error = "El archivo seleccionado no es una imagen";
                    
                }
            }
        }else{
            $error = "Ya exíste un libro con el mismo ISBN";
        }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'error' => $error,
        );
    }

    /**
     * Creates a form to create a Libro entity.
     *
     * @param Libro $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Libro $entity)
    {
        $form = $this->createForm(new LibroType(), $entity, array(
            'action' => $this->generateUrl('libro_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Libro entity.
     *
     * @Route("/crear", name="libro_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Libro();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'error' => false,
        );
    }

    /**
     * Finds and displays a Libro entity.
     *
     * @Route("/{id}", name="libro_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Libro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Libro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Libro entity.
     *
     * @Route("/{id}/editar", name="libro_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Libro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Libro entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'error' => false,
        );
    }

    /**
    * Creates a form to edit a Libro entity.
    *
    * @param Libro $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Libro $entity)
    {
        $form = $this->createForm(new LibroType(), $entity, array(
            'action' => $this->generateUrl('libro_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Libro entity.
     *
     * @Route("/{id}", name="libro_update")
     * @Method("PUT")
     * @Template("InicioBundle:Libro:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('InicioBundle:Libro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Libro entity.');
        }
        $error = false;
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('libro'));
        }else{
            $error = true;
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'error'       => $error,
        );
    }
    /**
     * Deletes a Libro entity.
     *
     * @Route("/{id}", name="libro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('InicioBundle:Libro')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Libro entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('libro'));
    }

    /**
     * Creates a form to delete a Libro entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('libro_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('InicioBundle:Libro')->find($id);
        $borrado= $entity->getBorrado();
        $entity->setBorrado(!$borrado);
        $em->flush();
        return $this->redirect($this->generateUrl('libro'));
    }
}
