<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ReservationType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('startDate', DateType::class, ['required' => true,
													'widget' => 'single_text',
													'format' => 'dd/MM/yyyy',
													'html5' => false])
				->add('endDate', DateType::class, ['required' => true,
													'widget' => 'single_text',
													'format' => 'dd/MM/yyyy',
													'html5' => false])
				->add('numberOfGuests', NumberType::class, ['required' => true])
				->add('submit', SubmitType::class);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(['data_class' => Reservation::class]);
	}
}
