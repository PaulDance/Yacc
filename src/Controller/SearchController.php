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
		$roomRepository = $this->getDoctrine()->getRepository(Room::class);
		$minMaxPrices = $roomRepository->findMinMaxPrices();
		$form = $this->createForm(AdvancedSearchType::class);
		$form->handleRequest($request);
		
		if ($form->isSubmitted()) {
			if ($form->isValid()) {
				return $this->redirectToRoute('search', [
							'room' => $form->get('room')->getData(),
							'region' => $form->get('region')->getData(),
							'startDate' => $form->get('startDate')->getData(),
							'endDate' => $form->get('endDate')->getData(),
							'minPrice' => $form->get('minPrice')->getData(),
							'maxPrice' => $form->get('maxPrice')->getData()
						]);
			}
			else {
				// Show error flashbag.
			}
		}
		else {
			dump('room: ' . $request->query->get('room'));
			dump('region: ' . $request->query->get('region'));
			dump('startDate: ' . $request->query->get('startDate'));
			dump('endDate: ' . $request->query->get('endDate'));
			dump('minPrice: ' . $request->query->get('minPrice'));
			dump('maxPrice: ' . $request->query->get('maxPrice'));
			
			$foundRooms = $roomRepository->findBySearch($request->query->get('room', ''),
														$request->query->get('region', ''),
														$request->query->get('minPrice', strval($minMaxPrices['minPrice'])),
														$request->query->get('maxPrice', strval($minMaxPrices['maxPrice'])));
		}
		
		return $this->render('search/index.html.twig', [
								'controller_name' => 'SearchController',
								'form' => $form->createView(),
								'rooms' => $foundRooms,
								'roomSearch' => $request->query->get('room', ''),
								'regionSearch' => $request->query->get('region', ''),
								'startDateSearch' => $request->query->get('startDate', ''),
								'endDateSearch' => $request->query->get('endDate', ''),
								'minPriceSearch' => $request->query->get('minPrice', $minMaxPrices['minPrice']),
								'maxPriceSearch' => $request->query->get('maxPrice', $minMaxPrices['maxPrice']),
								'minMinPrice' => $minMaxPrices['minPrice'],
								'maxMaxPrice' => $minMaxPrices['maxPrice']
							]);
	}
}
