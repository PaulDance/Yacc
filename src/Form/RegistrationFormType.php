<?php

namespace App\Form;

use App\Entity\UserAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class RegistrationFormType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('firstName', TextType::class, ['required' => false])
				->add('lastName', TextType::class, ['required' => true])
				->add('email', EmailType::class, ['required' => true])
				->add('password',
						PasswordType::class,
						['constraints' => [new Length(['min' => 6,
														'minMessage' => 'Your password should be at least {{ limit }} characters long.',
														'max' => 4096])]])
				->add('isClient', CheckboxType::class,
						['required' => false, 'mapped' => false])
				->add('isOwner', CheckboxType::class,
						['required' => false, 'mapped' => false]);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(['data_class' => UserAccount::class]);
	}
}
