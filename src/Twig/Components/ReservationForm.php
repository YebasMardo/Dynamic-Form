<?php

namespace App\Twig\Components;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ReservationForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    public function __construct(
        private ReservationRepository $reservationRepository,
    ) {
    }

    public function instantiateForm(): FormInterface
    {
        return $this->createForm(ReservationType::class, new Reservation());
    }

    #[LiveAction]
    public function save(): void
    {
        $this->submitForm();

        if (!$this->form->isValid()) {
            return;
        }

        /** @var Reservation $reservation */
        $reservation = $this->form->getData();
        $reservation->setUpdatedAt(new DateTimeImmutable());

        $this->reservationRepository->save($reservation, flush: true);

        $this->addFlash('success', 'Réservation créée avec succès!');
    }
}
