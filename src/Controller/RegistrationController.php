<?php

namespace App\Controller;

use App\Entity\UserAccount;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Entity\Client;
use App\Entity\Owner;


class RegistrationController extends AbstractController {
	/**
	 * @Route("/register", name="register", methods={"GET", "POST"})
	 */
	public function register(Request $request,
							UserPasswordEncoderInterface $passwordEncoder,
							GuardAuthenticatorHandler $guardHandler,
							LoginFormAuthenticator $authenticator): Response {
		$userAccount = new UserAccount();
		$form = $this->createForm(RegistrationFormType::class, $userAccount);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$userAccount->setPassword($passwordEncoder->encodePassword($userAccount, $form->get('password')->getData()));
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($userAccount);
			
			if ($form->get('isClient')->getData()) {
				$userAccount->addRole('ROLE_CLIENT');
				$entityManager->persist((new Client())->setUserAccount($userAccount));
			}
			
			if ($form->get('isOwner')->getData()) {
				$userAccount->addRole('ROLE_OWNER');
				$entityManager->persist((new Owner())->setUserAccount($userAccount));
			}
			
			$entityManager->flush();
			return $guardHandler->authenticateUserAndHandleSuccess($userAccount, $request, $authenticator, 'main');
		}
		
		return $this->render('registration/register.html.twig',
							['registrationForm' => $form->createView()]);
	}
}
