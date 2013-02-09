<?php

namespace SunshinePHP\Bundle\TodoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SunshinePHP\Bundle\TodoBundle\Entity\Todo;
use SunshinePHP\Bundle\TodoBundle\Form\TodoType;

/**
 * Todo controller.
 *
 * @Route("/todo")
 */
class TodoRESTController extends Controller
{
    /**
     * Lists all Todo entities.
     *
     * @Route("/", name="todo_rest")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SunshinePHPTodoBundle:Todo')->findAll();

        $response = new Response();
        $response->setContent($this->container->get('serializer')->serialize($entities, 'json'));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Finds and displays a Todo entity.
     *
     * @Route("/{id}", name="todo_rest_show")
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

        $response = new Response();
        $response->setContent($this->container->get('serializer')->serialize($entity, 'json'));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
