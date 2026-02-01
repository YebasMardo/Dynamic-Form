<?php

namespace App\Twig\Components;

use App\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ReservationForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    public function instantiateForm(): FormInterface
    {
        return $this->createForm(ReservationType::class);
    }
}
