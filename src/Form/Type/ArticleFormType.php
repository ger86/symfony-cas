<?php

namespace App\Form\Type;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Título'])
            ->add('body', TextareaType::class, ['label' => 'Texto'])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publicado', 
                'required' => false
            ])
            ->add('checkTerms', CheckboxType::class, [
                'label' => 'Acepto términos y condiciones',
                'mapped' => false
            ])
            ->add('save', SubmitType::class, ['label' => 'Guardar']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class
        ]);
    }
}
