<?php

namespace App\Form;

use App\Enum\FlightClass;
use App\Enum\SeatPreference;
use App\Enum\TransportType;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'label' => 'Type de transport',
                'placeholder' => 'Type de transport'
            ])
            ->add('isRoundTrip', CheckboxType::class, [
                'label' => 'Aller/Retour',
                'required' => false
            ])
            ->add('departureDate', DateType::class, [
                'label' => 'Date de départ',
                'widget' => 'single_text',
                'input' => 'datetime_immutable'
            ])
        ;

        $builder->addDependent('returnDate', 'isRoundTrip', function(DependentField $field, ?bool $isRoundTrip) {
            if($isRoundTrip) {
                $field->add(DateType::class, [
                    'label' => "Date d'arrivée",
                    'widget' => 'single_text',
                    'input' => 'datetime_immutable'
                ]);
            }
        });

        $builder->addDependent('flightClass', 'transportType', function(DependentField $field, ?TransportType $transportType) {
            if($transportType === TransportType::PLANE) {
                $field->add(EnumType::class, [
                    'class' => FlightClass::class,
                    'label' => "Classe",
                    'placeholder' => 'Classe'
                ]);
            }
        });

        $builder->addDependent('seatPreference', 'transportType', function(DependentField $field, ?TransportType $transportType) {
            if(!$transportType) {
                return;
            }

            $isPlane = $transportType === TransportType::PLANE;

            $field->add(EnumType::class, [
                'class' => SeatPreference::class,
                'choices' => $isPlane ? SeatPreference::plane() : SeatPreference::train(),
                'label' => 'Preference de siège',
                'placeholder' => 'Preference de siège'
            ]);
        });

        $builder->add('save', SubmitType::class, [
            'label' => 'Réserver',
            'priority' => -1
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class
        ]);
    }
}
