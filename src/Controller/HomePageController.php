<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\HomePage;
use App\Entity\Room;
use App\Entity\Region;
use App\Form\BasicSearchType;
use Symfony\Component\HttpFoundation\Request;


class HomePageController extends AbstractController {
	/**
	 * @Route("/", name="home_page", methods={"GET", "POST"})
	 */
	public function index(Request $request) {
		$basicSearchForm = $this->createForm(BasicSearchType::class);
		$basicSearchForm->handleRequest($request);
		
		if ($basicSearchForm->isSubmitted() && $basicSearchForm->isValid()) {
			return $this->redirectToRoute('search', [
							'region' => $basicSearchForm->get('region')->getData(),
							'startDate' => $basicSearchForm->get('startDate')->getData(),
							'endDate' => $basicSearchForm->get('endDate')->getData()
						]);
		}
		
		return $this->render('home_page/index.html.twig',
							['controller_name' => 'HomePageController',
								'basicSearchForm' => $basicSearchForm->createView(),
								'homePage' => $this->getDoctrine()
													->getRepository(HomePage::class)
													->getHomePage(),
								'randomRooms' => $this->getDoctrine()
													->getRepository(Room::class)
													->getRandom(3),
								'randomRegions' => $this->getDoctrine()
														->getRepository(Region::class)
														->getRandom(2)]);
	}
}
