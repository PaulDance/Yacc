<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HomePage;


class HomePageController extends AbstractController {
	/**
	 * @Route("/", name="home_page")
	 */
	public function index() {
		return $this->render('home_page/index.html.twig',
							['controller_name' => 'HomePageController',
								'homePage' => $this->getDoctrine()
													->getRepository(HomePage::class)
													->getHomePage() ]);
	}
}
