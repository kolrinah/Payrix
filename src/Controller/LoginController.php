<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Entity\Log;
use App\Form\LoginType;

/**
 * Account controller.
 *
 * @Route("/login")
 */
class LoginController extends Controller
{
    /**
     * @Route("/", name="login")
     *
     */
    public function index(Request $request)
    {
        $user = new User();
        $error = '';

        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $uR = $em->getRepository(User::class);
            $log = new Log();

            $userDb = $uR->findOneBy(['username' => $user->getUsername()]);

            if (!empty($userDb)) {

                if (password_verify($user->getPassword(), $userDb->getPassword())) {
                    $log->setDatetime(new \DateTime('now'));
                    $log->setIp($request->getClientIp());
                    $log->setUseragent($request->headers->get('user-agent'));
                    $log->setUser($userDb);
                    $em->persist($log);
                    $em->flush();
                    return $this->redirectToRoute('success_login', ['user' => $userDb->getFullname()]);
                }
            }
            $error = 'Username or Password incorrect';
        }

        return $this->render('login/index.html.twig', array(
            'form'  => $form->createView(),
            'error' => $error
        ));
    }

    /**
     * @Route("/success/{user}", name="success_login")
     *
     */
    public function success($user) {

        return $this->render('login/success.html.twig', ['user' => $user]);
    }
}
