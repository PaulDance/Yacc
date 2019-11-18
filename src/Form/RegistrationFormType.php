<?php

namespace App\Form;

use App\Entity\UserAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('email')
				->add('agreeTerms',
						CheckboxType::class,
						['mapped' => false,
							'constraints' => [new IsTrue(['message' => 'You should agree to our terms.'])]])
				->add('plainPassword',
						PasswordType::class,
						['mapped' => false,
							'constraints' => [new Length(['min' => 6,
														'minMessage' => 'Your password should be at least {{ limit }} characters long',
														'max' => 4096])]]);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(['data_class' => UserAccount::class,]);
	}
}
