<?php
namespace RPGBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Constraints;

class HeroCharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (isset($options['factory'])) {
            $dataType = array_flip($options['factory']->getAvailableCharacterTypes());
        } else {
            $dataType = [];
        }

        $builder
            ->add('name', TextType::class, [
                'label' => 'Please, name your hero',
                'constraints' => [
                    new Constraints\NotBlank(),
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Please, enter your password',
                'constraints' => [
                    new Constraints\Type(['type' => 'string']),
                    new Constraints\Length(['min' => 3, 'max' => 72]),
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Select what type of Hero you want',
                'choices' => $dataType
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => HeroCharacterFormData::class,
                'csrf_protection' => false,
            ]
        );
    }


}