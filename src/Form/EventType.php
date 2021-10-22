<?php


namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class EventType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options )
    {
        $builder

            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom de l\'événement'
                ]
            ])
            ->add('date', DateTimeType::class, [
                 'label' => 'Date',
                 'attr' => [
                     'placeholder' => 'Date de l\'événement'
                ],
                'time_label' => 'Heure',
                'data' => new \DateTime('NOW'),
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description / Commentaire (facultatif) Maximum 555 caractères'
                ],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Event::class
        ]);

    }
}