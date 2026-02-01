<?php

namespace App\Form;

use App\Enum\TransportType;
use App\Model\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DependentField;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('transportType', EnumType::class, [
                'class' => TransportType::class,
                'label' => 'Type de transport'
            ])
            ->add('isRoundTrip', CheckboxType::class, [
                'label' => 'Aller/Retour',
                'required' => false
            ])
            ->add('departureDate', DateType::class, [
                'label' => 'Date de départ'
            ])
        ;

        $builder->addDependent('returnDate', 'isRoundTrip', function(DependentField $field, ?bool $isRoundTrip) {
            if($isRoundTrip) {
                $field->add(DateType::class, [
                    'label' => "Date d'arrivée"
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class
        ]);
    }
}
