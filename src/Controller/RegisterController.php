<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\UserType;

/**
 * Account controller.
 *
 * @Route("/register")
 */
class RegisterController extends Controller
{
    /**
     * @Route("/", name="register")
     *
     */
    public function index(Request $request)
    {
        $user = new User();
        $error = '';

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $uR = $em->getRepository(User::class);

            $userDb = $uR->findBy(['username' => $user->getUsername()]);

            if (empty($userDb)) {
                $origPwd = $user->getPassword();
                $orgFN   = $user->getFullname();
                $user->setPassword(password_hash($origPwd, PASSWORD_BCRYPT));
                $user->setFullname(ucwords(strtolower($orgFN)));
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('success', ['user' => $user->getFullname()]);
            }
            $error = 'Username already being used';
        }

        return $this->render('register/index.html.twig', array(
            'form'  => $form->createView(),
            'error' => $error
        ));
    }

    /**
     * @Route("/success/{user}", name="success")
     *
     */
    public function success($user) {

        return $this->render('register/success.html.twig', ['user' => $user]);
    }
}
