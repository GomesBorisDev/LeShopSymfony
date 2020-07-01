<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/userSignUp", name="userSignUp")
     */
    public function userSignUp(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new Users();

        $form = $this->createForm(UsersType::class, $user);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('userLogin');
        }

        return $this->render('users/signUp.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/userLogin", name="userLogin")
     */
    public function userLogin()
    {

        return $this->render('users/login.html.twig', [
        ]);
    }
}
