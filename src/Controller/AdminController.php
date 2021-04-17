<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Form\PizzaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pizza_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pizza $pizza): Response
    {
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pizza_index');
        }

        return $this->render('pizza/edit.html.twig', [
            'pizza' => $pizza,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="pizza_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pizza = new Pizza();
        $form = $this->createForm(PizzaType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pizza);
            $entityManager->flush();

            return $this->redirectToRoute('pizza_index');
        }

        return $this->render('pizza/new.html.twig', [
            'pizza' => $pizza,
            'form' => $form->createView(),
        ]);
    }

}
