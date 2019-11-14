<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AdvancedSearchType;
use App\Entity\Room;


/**
 * @Route("/search")
 */
class SearchController extends AbstractController {
	/**
	 * @Route("", name="search", methods={"GET", "POST"})
	 */
	public function searchForm(Request $request) {
		$form = $this->createForm(AdvancedSearchType::class);
		$form->handleRequest($request);
		
		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				return $this->redirectToRoute('search', [
							'room' => $form->get('room')->getData(),
							'region' => $form->get('region')->getData()
						]);
			}
			else {
				// Show error flashbag.
			}
		}
		else {
			dump($request->query->get('room', ''));
			dump($request->query->get('region', ''));
			
			$foundRooms = $this->getDoctrine()
								->getRepository(Room::class)
								->findBySearch($request->query->get('room', ''),
												$request->query->get('region', ''));
		}
		
		return $this->render('search/index.html.twig', [
								'controller_name' => 'SearchController',
								'form' => $form->createView(),
								'rooms' => $foundRooms
							]);
	}
}
