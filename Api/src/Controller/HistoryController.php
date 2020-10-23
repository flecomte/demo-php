<?php

namespace Api\Controller;

use Api\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history/{date}", name="history", methods={"get"}, requirements={"date"="[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}"})
     */
    public function getHistory(string $date, Request $request, HistoryRepository $repository): JsonResponse
    {
        $result = $repository->findAll(
            $request->query->get('tag'),
            $date,
        );

        return $this->json($result);
    }
}
