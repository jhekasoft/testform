<?php

namespace Jhekasoft\Bundle\TestformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Jhekasoft\Bundle\TestformBundle\Form\PersonalDataType;
use Jhekasoft\Bundle\TestformBundle\Form\QuestionsType;

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
            'countdownInit' => true,
        ));
    }

    public function restartAction()
    {
        $countdown = $this->get('countdown');
        $countdown->reset();

        return $this->redirect($this->generateUrl('_testform_homepage'));
    }

    public function questionsAction(Request $request)
    {
        $countdown = $this->get('countdown');

        $repository = $this->getDoctrine()
            ->getRepository('JhekasoftTestformBundle:Testform');

        $testform = $repository->find($countdown->getTestformId());

        if (!$countdown->isStarted() || !$testform->getPersonalDataSetted()) {
            return $this->redirect($this->generateUrl('_testform_homepage'));
        }

        $form = $this->createForm(new QuestionsType($this->container->getParameter('questions')),
                null, array('csrf_protection' => false));

        return $this->render('JhekasoftTestformBundle:Default:questions.html.twig', array(
            'countdownSeconds' => $countdown->getCountdownSeconds(),
            'startTimestamp' => $countdown->getStartTimestamp(),
            'secondsLeft' => $countdown->getSecondsLeft(),
            'form' => $form->createView(),
            'countdownInit' => true,
        ));
    }

    public function winAction(Request $request)
    {
        $countdown = $this->get('countdown');

        $repository = $this->getDoctrine()
            ->getRepository('JhekasoftTestformBundle:Testform');

        $testform = $repository->find($countdown->getTestformId());

        if (!$countdown->isStarted() || !$testform->getEnded()) {
            return $this->redirect($this->generateUrl('_testform_questions'));
        }

        // Parse gif url
        $imagePageHtml = file_get_contents('http://www.gifbin.com/random');
        $crawler = new Crawler($imagePageHtml);
        $imageUrl = $crawler->filter('#gif')->attr('src');

        $countdown->reset();

        return $this->render('JhekasoftTestformBundle:Default:win.html.twig', array(
            'imageUrl' => $imageUrl,
            'secondsLeft' => $testform->getResultSeconds(),
            'countdownInit' => false,
        ));
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

        $em = $this->getDoctrine()->getManager();
        $em->persist($testform);

        if ($form->isValid()) {
            $testform->setUpdatedAt(new \DateTime());
            $testform->setPersonalDataSetted(true);

            $em->flush();

            return new JsonResponse(array(
                'result' => 'ok',
            ));
        }

        // Write errorlogs
        $errorlogs = $testform->getErrorlogs();
        $errorlogs[] = $form->getErrorsAsString();
        $testform->setErrorlogs($errorlogs);
        $em->flush();

        $formHtml = $this->renderView('JhekasoftTestformBundle:Default:personalDataForm.html.twig', array('form' => $form->createView()));
        return new JsonResponse(array(
            'result' => 'fail',
            'addFormHtml' => $formHtml,
        ));
    }

    public function saveQuestionsAction(Request $request)
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

        $form = $this->createForm(new QuestionsType($this->container->getParameter('questions')),
                $testform, array('csrf_protection' => false));
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $em->persist($testform);

        if ($form->isValid()) {
            $now = new \DateTime();
            $testform->setResultSeconds($countdown->getSecondsLeft());
            $testform->setUpdatedAt($now);
            $testform->setEndedAt($now);
            $testform->setEnded(true);

            $em->flush();

            return new JsonResponse(array(
                'result' => 'ok',
            ));
        }

        // Write errorlogs
        $errorlogs = $testform->getErrorlogs();
        $errorlogs[] = $form->getErrorsAsString();
        $testform->setErrorlogs($errorlogs);
        $em->flush();

        $formHtml = $this->renderView('JhekasoftTestformBundle:Default:questionsForm.html.twig', array('form' => $form->createView()));
        return new JsonResponse(array(
            'result' => 'fail',
            'addFormHtml' => $formHtml,
        ));
    }

    public function exportedDocumentAction()
    {
        $filename = 'testform_export.xml';
        $kernel = $this->get('kernel');
        $basePath = $kernel->locateResource('@JhekasoftTestformBundle');
        $filePath = $basePath . '/Resources/export/' . $filename;

        // Check if file exists
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException();
        }

        // Prepare BinaryFileResponse
        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            $filename
        );

        return $response;
    }
}
