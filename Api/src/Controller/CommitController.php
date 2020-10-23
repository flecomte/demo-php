<?php

namespace Api\Controller;

use Api\Repository\CommitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommitController extends AbstractController
{
    /**
     * Return all event that match with date and tag
     *
     * @Route("/commits/{date}", name="commit", methods={"get"}, requirements={"date"="[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}"})
     */
    public function getHistory(string $date, Request $request, CommitRepository $repository): JsonResponse
    {
        $result = $repository->findAll(
            $date,
            $request->query->get('tag'),
        );

        return $this->json($result);
    }
}
