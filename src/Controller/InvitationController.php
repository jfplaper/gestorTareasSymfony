<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Entity\Project;
use App\Entity\User;
use App\Repository\InvitationRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InvitationController extends AbstractController
{
    #[Route('/invitation', name: 'app_invitation')]
    public function index(InvitationRepository $invitationRepository): Response
    {
        $invitations = $invitationRepository->findAll();

        return $this->render('invitation/index.html.twig', [
            'invitations' => $invitations
        ]);
    }

    #[Route('/{id}/invitation/choose', name: 'app_invitation_choose_project', methods: ['GET', 'POST'])]
    public function chooseProject(User $user, ProjectRepository $projectRepository): Response
    {
        // Obtengo todos los proyectos colectivos existentes
        $projects = $projectRepository->findBy(["scope" => "colectivo"]);

        return $this->render('invitation/choose.html.twig', [
            'projects' => $projects,
            'user' => $user
        ]);
    }

    #[Route('/invitation/send/{id}/{user}', name: 'app_invitation_send', methods: ['GET', 'POST'])]
    public function send(Project $project, User $user, EntityManagerInterface $entityManager): Response
    {
        // Si no llamo al parámetro {user} y pongo idUser por ejemplo ya no detecta la entidad y no va
        $invitation = new Invitation();
        $invitation->setEmisor($this->getUser());
        $invitation->setProject($project);
        $invitation->setReceptor($user);
        $invitation->setState(null);

        $entityManager->persist($invitation);
        $entityManager->flush();

        return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
    }
}
