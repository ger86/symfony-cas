<?php

namespace App\Form\Type;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\Type\ArticleStateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $article = $event->getData();
            $form = $event->getForm();
            if (!$article || empty($article->getId())) {
                $form->add('checkTerms', CheckboxType::class, [
                    'label' => 'Acepto términos y condiciones',
                    'mapped' => false
                ]);
            }
        });
        $builder
            ->add('title', TextType::class, ['label' => 'Título'])
            ->add('body', TextareaType::class, ['label' => 'Texto'])
            ->add('state', ArticleStateType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publicado', 
                'required' => false
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
