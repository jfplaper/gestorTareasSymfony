<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(TaskRepository $taskRepository, ProjectRepository $projectRepository): Response
    {
        // Obtengo el proyecto personal del usuario logueado (pero me lo da en un array, por eso pongo [0])
        $personalProject = $projectRepository->findPersonalProject($this->getUser());
        $tasks = $taskRepository->findBy(["project" => $personalProject[0]]);

        return $this->render('main/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
