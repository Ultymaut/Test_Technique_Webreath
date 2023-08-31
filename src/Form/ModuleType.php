<?php

namespace App\Form;

use App\Entity\Module;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class ModuleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'Nom du Module',
                'label_attr'=>[
                    'class'=>'form_label mt-4'
                ],
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                ]
            ])
            ->add('description', TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control'
                ],
                'label'=>'Description du Module',
                'label_attr'=>[
                    'class'=>'form_label mt-4'
                ],
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success mt-4'
                ],
                'label' => 'Ajouter'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
