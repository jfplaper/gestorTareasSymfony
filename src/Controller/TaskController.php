<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task')]
final class TaskController extends AbstractController
{
    #[Route(name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Project $project, Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Establezco algunos valores de propiedades yo, no a través del formulario
            $task->setEndDate(null);
            $task->setProject($project);
            $task->setCreator($this->getUser());
            $task->setFinisher(null);
            if ($project->getScope() == "personal")
                $task->setAssigned($this->getUser());
            else
                $task->setAssigned(null);

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/completed', name: 'app_task_completed', methods: ['GET', 'POST'])]
    public function completed(Task $task, EntityManagerInterface $entityManager): Response
    {
        if (!$task->getEndDate()) {
            $task->setEndDate(new \DateTime());
            $task->setFinisher($this->getUser());
        } else {
            $task->setEndDate(null);
            $task->setFinisher(null);
        }

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/completed/collective', name: 'app_task_completed_collective', methods: ['GET', 'POST'])]
    public function completedCollective(Task $task, EntityManagerInterface $entityManager): Response
    {
        if (!$task->getEndDate()) {
            $task->setEndDate(new \DateTime());
            $task->setFinisher($this->getUser());
        } elseif (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $task->setEndDate(null);
            $task->setFinisher(null);
        }

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/assign/{id}/{project}', name: 'app_task_assign', methods: ['GET', 'POST'])]
    public function assign(Task $task, Project $project, UserRepository $userRepository): Response
    {
        // Obtengo los usuarios de ese proyecto colectivo
        $users = $userRepository->findUsersCollectiveProject($project);

        return $this->render('task/assign.html.twig', [
            'task' => $task,
            'users' => $users
        ]);
    }

    #[Route('/assign/confirm/{id}/{user}', name: 'app_task_confirm_assignment', methods: ['GET', 'POST'])]
    public function send(Task $task, User $user, EntityManagerInterface $entityManager): Response
    {
        // Si no llamo al parámetro {user} y pongo idUser por ejemplo ya no detecta la entidad y no va
        $task->setAssigned($user);

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/eliminate', name: 'app_task_eliminate', methods: ['GET'])]
    public function eliminate(Task $task, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
    }
}
