<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Foctionne
     * @Route("/tasks", name="task_list")
     */
    public function listAction(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig',
            ['tasks' => $taskRepository->findAll()]);
    }

    /**
     * Foctionne
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $user = $this->getUser();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user){
                $task->setUsers($user);
            }
            $em = $this->getDoctrine()->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    //TODO Ajouter le code en commentaire
    /*
     *    public function editAction($id, Request $request,TaskRepository $taskRepository)
    {
        $task = $taskRepository->find($id);
     */
    public function editAction(Task $task, Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user){
                $task->setUsers($user);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    //TODO Faire les memes modifs

    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @param int $id
     * @param UserInterface|null $user
     * @param TaskRepository $taskRepository
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteTaskAction(int $id, ?UserInterface $user, TaskRepository $taskRepository, security $security)
    {
        $delete = false;

        if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('homepage');
        }

        if ($id != $taskRepository->find($id)->getId()){
            return $this->redirectToRoute('homepage');
        }

        $tasksUserConnecte = $taskRepository->findBy(['users' => $user->getId()]);

        foreach ($tasksUserConnecte as $task){
            if ($task->getId() == $id) {
                $delete = true;
            }
        }

        if ($user->getRoles() == 'ROLE_ADMIN') {
            $delete = true;
        }

        if ($delete == true){
            $em = $this->getDoctrine()->getManager();
            $task = $em->getRepository(Task::class)->find($id);
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');
            return $this->redirectToRoute('task_list');
        }else{
            return $this->redirectToRoute('homepage');
        }
    }

}
