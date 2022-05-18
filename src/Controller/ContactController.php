<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
  
    
     /**
     * @Route("/contacterie", name="app_contact")
     */
    public function add(Request $request,  ManagerRegistry $managerRegistry): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success', 'Votre demande a bien été reçue.');

            return $this->redirectToRoute("app_home");
        }
        return $this->render('contact/add.html.twig', [
            'contact' => $contact,
            'form' => $form->createView()
        ]);
    }
}
