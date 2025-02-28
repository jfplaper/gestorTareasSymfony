<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectUser;
use App\Repository\ProjectRepository;
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
}
