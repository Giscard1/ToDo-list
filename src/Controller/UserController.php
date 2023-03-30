<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Config\Security\FirewallConfig\RememberMe\TokenProvider\DoctrineConfig;

class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/users", name="user_list")
     * @param UserRepository $userRepository
     */
    public function listAction(UserRepository $userRepository)
    {
        if (!$this->security->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('homepage');
        }
        return $this->render('user/list.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/users/create", name="user_create")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, UserPasswordHasherInterface $passwordHasher, security $security)
    {
        //redirige l'utilisateur vers la homepage s'il n'est pas connecté
        //if (!$this->security->isGranted('IS_AUTHENTICATED_FULLY')){
           
        if (!$this->security->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $plaintextPassword = $form["password"]->getData();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            $user->setPassword($hashedPassword);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function editAction($id, Request $request, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        //if ($form->isValid()) {
        if ($form->isSubmitted() && $form->isValid()) {
            //$password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            //$user->setPassword($password);
            //Todo hacher le mot de passe

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
