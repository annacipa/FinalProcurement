<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfertaType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pershkrimi',TextareaType::class)
            ->add('vlefta',IntegerType::class)
            ->add('adresaDorezimit',TextType::class)
            ->add('document', FileType::class, [
                'label' => 'Dokumenta',
                'mapped' => false,
                'required' => false,
                'multiple'=>true
            ]);
//            ->add('isDeleted')
//            ->add('createdBy')
//            ->add('vendimi')
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Oferta'
        ));
    }


}
