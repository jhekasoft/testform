<?php

namespace Jhekasoft\Bundle\RegistrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Jhekasoft\Bundle\RegistrationBundle\Form\Type\RegistrationType;
use Jhekasoft\Bundle\RegistrationBundle\Form\Model\Registration;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JhekasoftRegistrationBundle:Default:index.html.twig');
    }

    public function registerAction()
    {
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('_registration_create'),
        ));

        return $this->render(
            'JhekasoftRegistrationBundle:Default:register.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            // Password encoding
            $user = $registration->getUser();
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
            $user->setActive(false);
            $user->setVerificationHash(bin2hex(mcrypt_create_iv(128, MCRYPT_DEV_RANDOM)));

            $em->persist($user);
            $em->flush();


            // Email sending
            $message = \Swift_Message::newInstance()
                ->setSubject('Jhekasoft Registration - Verification')
                ->setFrom('info@' . $this->getRequest()->getHost())
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'JhekasoftRegistrationBundle:Default:emailVerification.html.twig',
                        array('link' => $this->generateUrl('_registration_verificate', array(
                            'hash' => $user->getVerificationHash()
                        ))
                    )
                )
            );
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('_registration_completed', array(
                'email' => $registration->getUser()->getEmail(),
            )));
        }

        return $this->render(
            'JhekasoftRegistrationBundle:Default:register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function completedAction($email)
    {
        return $this->render('JhekasoftRegistrationBundle:Default:completed.html.twig', array(
            'email' => $email,
        ));
    }

    public function verificateAction($hash)
    {
        $repository = $this->getDoctrine()
            ->getRepository('JhekasoftRegistrationBundle:User');

        $user = $repository->findOneByVerificationHash($hash);

        $email = NULL;
        $verificated = false;
        if ($user) {
            $email = $user->getEmail();
            $verificated = true;

            // Set active
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $user->setActive(true);
            $em->flush();
        }

        return $this->render('JhekasoftRegistrationBundle:Default:verificate.html.twig', array(
            'verificated' => $verificated,
            'email' => $email,
        ));
    }

    public function loginAction(Request $request)
    {
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('JhekasoftRegistrationBundle:Default:login.html.twig', array(
            'last_username' => $request->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }


    public function logoutAction()
    {
        // The security layer will intercept this request
    }
}
