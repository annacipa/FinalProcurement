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

class BiznesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emer_biznesi',TextType::class)
            // ->add('role_id', EntityType::class, [
            //     'class' => 'AppBundle:Role',
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('r')
            //                 ->where('r.id != :id')
            //                 ->setParameter('id', 4);
            //     },
            //     'choice_label' => 'emer_roli',
            // ])
            ->add('nipt',TextType::class)
            ->add('email', EmailType::class)
            ->add('adresa',TextType::class)
            ->add('logo', FileType::class, [
//                'label' => 'Logo (JPEG)',
                'required' => true,
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
//                'multiple'=>true


            ])
//                ->add('bashkia',ChoiceType::class,[
//                    'choices' => [
//                      'Belsh'=>'Belsh',
//                       'Berat'=>'Berat'   ]
//
//                ])
            ->add('numerTelefoni',NumberType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field form-groupphp']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ]);

//            ->add('password', PasswordType::class);
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
