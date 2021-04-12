<?php


namespace AppBundle\Form;

use AppBundle\Entity\FushaOperimi;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class TenderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titullThirrje',TextType::class)
            ->add('pershkrim',TextareaType::class)
            ->add('fondLimit',IntegerType::class)
            ->add('adresaDorezimit',TextType::class)

            ->add('dataPerfundimit',DateTimeType::class)
            ->add('licenca',TextType::class)
//            ->add('isDeleted')
//            ->add('createdBy')
//            ->add('status')
//            ->add('emerStatusi')
//            ->add('dataFillimit')
            ->add('fushe_operimi_id',EntityType::class,[
                'class'=> FushaOperimi::class,
                'choice_label' => 'emer fushe operimi',
                'choice_value'=>'id'

            ])
            ->add('document', FileType::class, [
                'label' => 'Dokumenta',
                'mapped' => false,
                'required' => false,
                'multiple'=>true
            ]);

//            ->add('submit',SubmitType::class);

    }
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'data_class' => Tender::class,
//        ]);
//
//    }
}
