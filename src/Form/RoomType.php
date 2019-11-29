<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RoomType extends AbstractType{
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('summary', TextType::class, ['required' => true])
				->add('description', TextareaType::class, ['required' => true])
				->add('capacity', NumberType::class, ['required' => true])
				->add('area', NumberType::class, ['required' => true])
				->add('price', NumberType::class, ['required' => true])
				->add('address', TextType::class, ['required' => true])
				->add('owner', null, ['required' => true])
				->add('regions', null, ['required' => true]);
	}

	public function configureOptions(OptionsResolver $resolver){
		$resolver->setDefaults(['data_class' => Room::class,]);
	}
}
