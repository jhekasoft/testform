<?php

namespace Jhekasoft\Bundle\TestformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jhekasoft\Bundle\TestformBundle\Form\PersonalDataType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $countdown = $this->get('countdown');
        $countdown->start();

        $form = $this->createForm(new PersonalDataType(), null, array('csrf_protection' => false));

        return $this->render('JhekasoftTestformBundle:Default:index.html.twig', array(
            'countdownSeconds' => $countdown->getCountdownSeconds(),
            'startTimestamp' => $countdown->getStartTimestamp(),
            'secondsLeft' => $countdown->getSecondsLeft(),
            'form' => $form->createView(),
        ));
    }

    public function restartAction()
    {
        $countdown = $this->get('countdown');
        $countdown->reset();

        return $this->redirect($this->generateUrl('_testform_homepage'));
    }

    public function saveQuestionsAction(Request $request)
    {

    }

    public function savePersonalDataAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedHttpException('Not ajax request');
        }

        $countdown = $this->get('countdown');

        $repository = $this->getDoctrine()
            ->getRepository('JhekasoftTestformBundle:Testform');

        $testform = $repository->find($countdown->getTestformId());

        if (!$testform) {
            return new JsonResponse(array(
                'result' => 'fail',
            ));
        }

        $form = $this->createForm(new PersonalDataType(), $testform, array('csrf_protection' => false));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $testform->setUpdatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($testform);
            $em->flush();

            return new JsonResponse(array(
                'result' => 'ok',
            ));
        }

        $formHtml = $this->renderView('JhekasoftTestformBundle:Default:personalDataForm.html.twig', array('form' => $form->createView()));
        return new JsonResponse(array(
            'result' => 'fail',
            'addFormHtml' => $formHtml,
        ));
    }
}
