<?php


namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option): void
    {
        $builder
            ->add('username', EmailType::class, [
                'label' => 'Identifiant',
                'attr' => [
                    'placeholder' => 'Email de connexion ...'
                ]
            ])->add('password', PasswordType::class, [
                'label' => 'Mot de passe ...',
                'attr' => [
                    'placeholder' => 'Mot de passe...'
                ]
            ]);
    }
}