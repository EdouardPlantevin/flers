<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $manager
    ){}

    #[Route('/', name: 'admin_index')]
    public function index(CustomerRepository $customerRepository, Request $request): Response
    {

        $form = $this->createForm(CustomerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($request->request->all());
        }
        return $this->render('back/dashboard.html.twig', [
            'customers' => $customerRepository->findAll()
        ]);
    }

    #[Route('/edit/{id}', name: 'admin_edit')]
    public function edit(Customer $customer, Request $request): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            $this->addFlash("success", "L'email à bien été modifié");
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('back/edit-customer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_delete')]
    public function delete(Customer $customer): Response
    {
        $this->manager->remove($customer);
        $this->manager->flush();
        $this->addFlash("success", "L'email à bien été supprimer");
        return $this->redirectToRoute('admin_index');
    }
}