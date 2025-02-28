<?php

namespace App\Controller;

use App\Repository\InvitationRepository;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ProjectRepository $projectRepository, TaskRepository $taskRepository, InvitationRepository $invitationRepository): Response
    {   
        $tasks = null;
        $invitations = null;
        $projects = null;
        
        if ($this->getUser()) {
            // Obtengo el proyecto personal del usuario logueado (pero me lo da en un array, por eso pongo [0] luego)
            $personalProject = $projectRepository->findPersonalProject($this->getUser());

            // Obtengo las tareas de su proyecto personal
            $tasks = $taskRepository->findBy(["project" => $personalProject[0]]);

            // Obtengo las invitaciones del usuario logueado
            $invitations = $invitationRepository->findBy(["receptor" => $this->getUser()]);

            // Obtengo sólo los proyectos colectivos del usuario logueado
            $projects = $projectRepository->findCollectiveProjects($this->getUser());
        }

        return $this->render('main/index.html.twig', [
            'tasks' => $tasks,
            'invitations' => $invitations,
            'projects' => $projects
        ]);
    }
}
