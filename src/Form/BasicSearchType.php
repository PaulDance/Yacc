<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class BasicSearchType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('region', SearchType::class, ['required' => false])
				->add('startDate', TextType::class, ['required' => false])
				->add('endDate', TextType::class, ['required' => false])
				->add('submitButton', SubmitType::class);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults([]);
	}
}
