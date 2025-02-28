<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectUser;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project')]
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects
        ]);
    }

    #[Route('/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Guardamos el texto del input en una variable
        $projectName = $request->query->get('project_name');

        if (isset($projectName) && $projectName != "") {
            $project = new Project();
            $project->setName($projectName);
            $project->setScope("colectivo");

            $projectUser = new ProjectUser();
            $projectUser->setProject($project);
            $projectUser->setUser($this->getUser());
            $projectUser->setRelationType("creador");

            $entityManager->persist($project);
            $entityManager->flush();
            $entityManager->persist($projectUser);
            $entityManager->flush();

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/detail', name: 'app_project_detail', methods: ['GET'])]
    public function detail(Project $project, TaskRepository $taskRepository): Response
    {
        // Nota previa: NO usar nombres como show, edit, new si no son los creados automáticamente por make:crud
        // Obtengo las tareas para ese proyecto colectivo en concreto
        $tasks = $taskRepository->findBy(["project" => $project]);

        return $this->render('project/detail.html.twig', [
            'project' => $project,
            'tasks' => $tasks
        ]);
    }
}
