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

class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {

        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($customer);
            $manager->flush();

            $this->addFlash("success", "Votre inscription à bien été prise en compte");

            return $this->redirect($request->getUri());
        }

        return $this->render('front/homepage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/radiation', name: 'home_remove')]
    public function remove(Request $request, CustomerRepository $customerRepository, EntityManagerInterface $manager): Response
    {

        if ($request->getMethod() == "POST") {
            $customer = $customerRepository->findOneBy(['email' => $request->get('email')]);

            if (!$customer) {
                $this->addFlash("warning", "Aucune adresse mail trouvé");
            }

            $manager->remove($customer);
            $manager->flush();

            $this->addFlash("success", "Votre demande à bien été prise en compte");

            return $this->redirectToRoute('home_index');
        }

        return $this->render('front/remove-customer.html.twig');
    }
}