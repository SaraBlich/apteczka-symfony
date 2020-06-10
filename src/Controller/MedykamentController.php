<?php

namespace App\Controller;

use App\Entity\Medykament;
use App\Form\MedykamentType;
use App\Repository\MedykamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medykament")
 */
class MedykamentController extends AbstractController
{
    /**
     * @Route("/{id}/utylizuj", name="medykament_utylizuj", methods={"POST"})
     */
    public function utylizuj(Request $request, int $id,  MedykamentRepository $repo): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $medykament = $repo->find($id);
        $liczba = $request->request->get('liczba', 0);
        $medykament->setZutylizowanych($medykament->getZutylizowanych() + $liczba);
        $medykament->setIlosc($medykament->getIlosc() - $liczba);
        if ($medykament->getIlosc() == 0) {
            $entityManager->remove($medykament);
        }
        $entityManager->flush();

        return $this->redirectToRoute('apteczka_show', [
            'id' => $medykament->getApteczka()->getId(),
        ]);
    }

    /**
     * @Route("/{id}/wydaj", name="medykament_wydaj", methods={"POST"})
     */
    public function wydaj(Request $request, int $id,  MedykamentRepository $repo): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $medykament = $repo->find($id);
        $liczba = $request->request->get('liczba', 0);
        $medykament->setWydanych($medykament->getWydanych() + $liczba);
        $medykament->setIlosc($medykament->getIlosc() - $liczba);
        if ($medykament->getIlosc() == 0) {
            $entityManager->remove($medykament);
        }
        //walidacja ilosci dodac :)
        $entityManager->flush();

        return $this->redirectToRoute('apteczka_show', [
            'id' => $medykament->getApteczka()->getId(),
        ]);
    }
}