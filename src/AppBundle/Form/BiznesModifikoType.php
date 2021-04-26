<?php

namespace AppBundle\Form;

use AppBundle\Entity\FushaOperimi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BiznesModifikoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emer_biznesi',TextType::class)
          
            ->add('email', EmailType::class)
            ->add('adresa',TextType::class)
            ->add('logo', FileType::class, [
               
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                        ],
                    ])
                ],
            ])
            ->add('fushe_operimi_id',EntityType::class,[
                'class'=> FushaOperimi::class,
                'choice_label' => 'emer fushe operimi',
                'choice_value'=>'id',
                'label'=>'Fushe Operimi'
            ])

            ->add('numerTelefoni',NumberType::class)
           ;

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Biznes'
        ));
    }




}
