<?php

namespace SunshinePHP\Bundle\TodoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SunshinePHP\Bundle\TodoBundle\Entity\Todo;
use SunshinePHP\Bundle\TodoBundle\Form\TodoType;

/**
 * Todo controller.
 *
 * @Route("/examples/todo")
 */
class TodoController extends Controller
{
    /**
     * Lists all Todo entities.
     *
     * @Route("/", name="todo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SunshinePHPTodoBundle:Todo')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Todo entity.
     *
     * @Route("/", name="todo_create")
     * @Method("POST")
     * @Template("SunshinePHPTodoBundle:Todo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Todo();
        $form = $this->createForm(new TodoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('todo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Todo entity.
     *
     * @Route("/new", name="todo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Todo();
        $form   = $this->createForm(new TodoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Todo entity.
     *
     * @Route("/{id}", name="todo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SunshinePHPTodoBundle:Todo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Todo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Todo entity.
     *
     * @Route("/{id}/edit", name="todo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SunshinePHPTodoBundle:Todo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Todo entity.');
        }

        $editForm = $this->createForm(new TodoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Todo entity.
     *
     * @Route("/{id}", name="todo_update")
     * @Method("PUT")
     * @Template("SunshinePHPTodoBundle:Todo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SunshinePHPTodoBundle:Todo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Todo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TodoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('todo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Todo entity.
     *
     * @Route("/{id}", name="todo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SunshinePHPTodoBundle:Todo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Todo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('todo'));
    }

    /**
     * Creates a form to delete a Todo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
