<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Comment;


class CommentType extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('text', TextareaType::class, ['required' => true])
				->add('submit', SubmitType::class);
	}
	
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(['data_class' => Comment::class]);
	}
}
