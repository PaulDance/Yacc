<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class AdvancedSearchType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('room', SearchType::class, ['required' => false])
				->add('region', SearchType::class, ['required' => false])
				->add('startDate', DateType::class, ['required' => false])
				->add('endDate', DateType::class, ['required' => false])
				->add('priceInterval', RangeType::class, [
						'required' => false,
						'attr' => [
								'min' => 20,
								'max' => 200
						]
				])
				->add('submit', SubmitType::class);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults([]);
	}
}
