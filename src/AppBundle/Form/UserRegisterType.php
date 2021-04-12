<?php 
namespace AppBundle\Form;

use AppBundle\Entity\Biznes;
use AppBundle\Entity\FushaOperimi;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class UserRegisterType extends AbstractType
{
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
                'required' => false,
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
            ->add('bashkia',ChoiceType::class,[
                    'choices' => [
                        'Belsh'=>'Belsh',
                        'Berat'=>'Berat',
                        'Bulqizë'=>'Bulqizë',
                        'Cërrik'=>'Cërrik',
                        'Delvinë'=>'Delvinë',
                        'Devoll'=>'Devoll',
                        'Dibër'=>'Dibër',
                        'Divjakë'=>'Divjakë',
                        'Dropull'=>'Dropull',
                        'Durrës'=>'Durrës',
                        'Elbasan'=>'Elbasan',
                        'Fier'=>'Fier',
                        'Finiq'=>'Finiq',
                        'Fushë-Arrëz'=>'Fushë-Arrëz',
                        'Gjirokastër'=>'Gjirokastër',
                        'Gramsh'=>'Gramsh',
                        'Has'=>'Has',
                        'Himarë'=>'Himarë',
                        'Kamëz'=>'Kamëz',
                        'Kavajë'=>'Kavajë',
                        'Këlcyrë'=>'Këlcyrë',
                        'Klos'=>'Klos',
                        'Kolonjë'=>'Kolonjë',
                        'Konispol'=>'Konispol',
                        'Korçë'=>'Korçë',
                        'Krujë'=>'Krujë',
                        'Kuçovë'=>'Kuçovë',
                        'Kukës'=>'Kukës',
                        'Kurbin'=>'Kurbin',
                        'Lezhë'=>'Lezhë',
                        'Libohovë'=>'Libohovë',
                        'Librazhd'=>'Librazhd',
                        'Lushnjë'=>'Lushnjë',
                        'Malësi e Madhe'=>'Malësi e Madhe',
                        'Maliq'=>'Maliq',
                        'Mallakastër'=>'Mallakastër',
                        'Mat'=>'Mat',
                        'Memaliaj'=>'Memaliaj',
                        'Mirditë'=>'Mirditë',
                        'Patos'=>'Patos',
                        'Peqin'=>'Peqin',
                        'Përmet'=>'Përmet',
                        'Pogradec'=>'Pogradec',
                        'Poliçan'=>'Poliçan',
                        'Prrenjas'=>'Prrenjas',
                        'Pukë'=>'Pukë',
                        'Pustec'=>'Pustec',
                        'Roskovec'=>'Roskovec',
                        'Rrogozhinë'=>'Rrogozhinë',
                        'Sarandë'=>'Sarandë',
                        'Selenicë'=>'Selenicë',
                        'Shijak'=>'Shijak',
                        'Shkodër'=>'Shkodër',
                        'Skrapar'=>'Skrapar',
                        'Tepelenë'=>'Tepelenë',
                        'Tiranë'=>'Tiranë',
                        'Tropojë'=>'Tropojë',
                        'Ura Vajgurore'=>'Ura Vajgurore',
                        'Vau i Dejës'=>'Vau i Dejës',
                        'Vlorë'=>'Vlorë',
                        'Vorë'=>'Vorë'


                    ]

                ])
            ->add('numerTelefoni',NumberType::class)
          ->  add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ])
//            ->add('password', PasswordType::class)
            ->add('submit',SubmitType::class, ['label'=>'Regjistrohu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Biznes::class,
        ]);
    }
}