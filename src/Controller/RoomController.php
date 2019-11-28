<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReservationType;
use App\Entity\Reservation;


/**
 * @Route("/room")
 */
class RoomController extends AbstractController {
	/**
	 * @Route("/new", name="room_new", methods={"GET","POST"})
	 */
	public function new(Request $request): Response {
		$room = new Room();
		$form = $this->createForm(RoomType::class, $room);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($room);
			$entityManager->flush();
			
			return $this->redirectToRoute('room_index');
		}
		
		return $this->render('room/new.html.twig',
								['room' => $room, 'form' => $form->createView()]);
	}
	
	/**
	 * @Route("/{id}", name="room_show", methods={"GET", "POST"})
	 */
	public function show(Room $room, Request $request): Response {
		$reservation = new Reservation();
		$reservationForm = $this->createForm(ReservationType::class, $reservation);
		$reservationForm->handleRequest($request);
				
		if ($reservationForm->isSubmitted()) {
			if ($reservationForm->isValid()) {
				$userAccount = $this->getUser();
				
				if (!$userAccount) {
					//$this->addFlash(?, "You must be logged in to make a reservation.");
					return $this->redirectToRoute('login');
				}
				else {
					$client = $userAccount->getPossibleClient();
					
					if ($client && $userAccount->hasRole('ROLE_CLIENT')) {
						if ($room && $room->getCapacity() >= intval($reservationForm->get('numberOfGuests')->getData())
								&& $room->isFreeBetween($reservationForm->get('startDate')->getData(),
														$reservationForm->get('endDate')->getData())) {
							$entityManager = $this->getDoctrine()->getManager();
							$reservation->setRoom($room);
							$reservation->setClient($client);
							$entityManager->persist($reservation);
							$entityManager->flush();
							
							//$this->addFlash(?, "Reservation successful.");
							return $this->redirectToRoute('home_page');
						}
						else {
							//$this->addFlash(?, "Room availability and capacity cannot meet your request.");
						}
					}
					else {
						//$this->addFlash(?, "You must be registered as client to make a reservation.")
					}
				}
			}
		}
		
		return $this->render('room/show.html.twig',
							['room' => $room,
								'reservationForm' => $reservationForm->createView()]);
	}
	
	/**
	 * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
	 */
	public function edit(Request $request, Room $room): Response {
		$form = $this->createForm(RoomType::class, $room);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();
			
			return $this->redirectToRoute('room_index');
		}
		
		return $this->render('room/edit.html.twig',
								['room' => $room, 'form' => $form->createView()]);
	}
	
	/**
	 * @Route("/{id}", name="room_delete", methods={"DELETE"})
	 */
	public function delete(Request $request, Room $room): Response {
		if ($this->isCsrfTokenValid('delete' . $room->getId(),
									$request->request->get('_token'))) {
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->remove($room);
			$entityManager->flush();
		}
		
		return $this->redirectToRoute('room_index');
	}
}
