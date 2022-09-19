<?php

namespace App\Form;

use App\Entity\Applications;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;

class EditApplicationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('text')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Новое' => 'Новое',
                    'В работе' => 'В работе',
                    'Завершена' => 'Завершена',
                    'Отменена' => 'Отменена',
                ],
            ])
            ->add('file_1', FileType::class, [                
                'mapped' => false,
                'required' => false,
                'multiple' => true,                
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '10M',
                                'mimeTypes' => [
                                    'image/gif',
                                    'image/jpeg',
                                    'image/png',
                                    'image/tiff'
                                ],
                                'mimeTypesMessage' => 'Не валиден',
                            ])
                        ]
                    ])
                ] 
            ])
            //->add('file_1')
            //->add('file_2')
            //->add('file_3')
            //->add('created_at')
            //->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Applications::class,
        ]);
    }
}
