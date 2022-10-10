<?php

namespace App\Form;

use App\Entity\Applications;
//use App\Entity\ApplicationFile;
//use App\Form\FileT;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('text')            
            ->add('application_file', FileType::class, [                
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
            
            // CollectionType::class, array(
            //     'data_class' => null,
            //     'entry_type' => FileT::class,
            //     'allow_add' => true,
            //     'by_reference' => false,
            //     'allow_delete' => true,
            //     'prototype' => true 
            // ))            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Applications::class,            
        ]);
    }
}
