<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class SecurityController extends AbstractController {
	/**
	 * @Route("/login", name="login")
	 */
	public function login(AuthenticationUtils $authenticationUtils): Response {
		if ($this->getUser()) {								// If a user is already logged in the current session,
			return $this->redirectToRoute('home_page');		// he cannot log in a second time, so redirect to home.
		}
		
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();
		
		return $this->render('security/login.html.twig',
								['last_username' => $lastUsername,
									'error' => $error]);
	}
	
	/**
	 * @Route("/logout", name="logout")
	 */
	public function logout() {
		// No special logout action needed here, the main part is managed by the firewall.
	}
}
