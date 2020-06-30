<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * @Route("/userSignUp", name="userSignUp")
     */
    public function userSignUp(Request $request, EntityManagerInterface $manager)
    {
        $user = new Users();

        $form = $this->createForm(UsersType::class, $user);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('users/signUp.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
