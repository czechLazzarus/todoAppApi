<?php

namespace TodoBundle\Controller;

use Doctrine\DBAL\Exception\ConstraintViolationException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use TodoBundle\Entity\Todo;

class TodoController extends FOSRestController
{
    
    /**
     * @Rest\Get("/todos")
     * @View(statusCode=200)
     */
    public function getTodos()
    {
        $todos = $this->getDoctrine()
                      ->getRepository('TodoBundle:Todo')
                      ->findAll();

        if ($todos === null) {
            throw $this->createNotFoundException('No todos to send');
        }

        return $todos;
    }

    /**
     * @Rest\Get("/todos/{id}")
     * @View(statusCode=200)
     */
    public function getTodo($id)
    {
        $todo = $this->getDoctrine()
                     ->getRepository('TodoBundle:Todo')
                     ->find($id);
        if ($todo === null) {
            throw $this->createNotFoundException('Todo not found');
        }

        return $todo;
    }

    /**
     * @Rest\Patch("/todos/{id}")
     * @View(statusCode=200)
     */
    public function completeTodo($id)
    {
        $todo = $this->getDoctrine()
                     ->getRepository('TodoBundle:Todo')
                     ->find($id);

        if ($todo === null) {
            throw $this->createNotFoundException('Todo not found');
        } else {
            $em = $this->getDoctrine()
                       ->getManager();
            $todo->setComplete(true);
            $em->persist($todo);
            $em->flush();

            return $todo;
        }
    }

    /**
     * @Rest\Delete("/todos/{id}")
     * @View(statusCode=204)
     */
    public function deleteTodo($id)
    {
        $todo = $this->getDoctrine()
                     ->getRepository('TodoBundle:Todo')
                     ->find($id);
        $em   = $this->getDoctrine()
                     ->getManager();

        try {
            if ($todo === null) {
                throw $this->createNotFoundException('Todo not found');
            }
            $em->remove($todo);
            $em->flush();
        } catch(ConstraintViolationException $e) {
            throw $this->createNotFoundException('Todo not found');
        }
    }

    /**
     * @Rest\Post("/todos")
     * @View(statusCode=201)
     * @ParamConverter("todo", converter="fos_rest.request_body")
     */
    public function addTodo(Todo $todo)
    {
        if ($todo->getTitle() === null) {
            throw new BadRequestHttpException('Bad data format');
        } else {
            $em = $this->getDoctrine()
                       ->getManager();
            $em->persist($todo);
            $em->flush();

            return $todo;
        }
    }
}
