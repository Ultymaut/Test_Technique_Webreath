<?php

namespace App\Form;

use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;


class RestartModuleType extends AbstractType
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
                //attr => sert a mettre une class bootstrap ou autre
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
                'label'=>'Description du Module : ',
                'label_attr'=>[
                    'class'=>'form_label mt-4 mb-2'
                ],
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                ]
            ])
            ->add('isWorking', CheckboxType::class, [
                'label' => 'Redémarrer le module',
                'required' => false,
                'attr' =>[
                    'class'=>'form-check-input'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-outline-success mt-4'
                ],
                'label' => 'Enregistrer'
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
