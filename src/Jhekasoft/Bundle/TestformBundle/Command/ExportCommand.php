<?php

namespace Jhekasoft\Bundle\TestformBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('testform:export')
            ->setDescription('Testform export')
            ->addArgument('finish-email', InputArgument::OPTIONAL, 'Finishing notify email')
        ;
    }

    protected function getProtectionFilepath()
    {
        $filename = 'export_run';
        $kernel = $this->getContainer()->get('kernel');
        $exportPath = $kernel->locateResource('@JhekasoftTestformBundle') . '/Resources/export/';
        $filePath = $exportPath . $filename;

        if (!file_exists($exportPath)) {
            mkdir($exportPath);
        }

        return $filePath;
    }

    protected function setOneInstanceProtection()
    {
        file_put_contents($this->getProtectionFilepath(), '1');
    }

    protected function unsetOneInstanceProtection()
    {
        unlink($this->getProtectionFilepath());
    }

    protected function checkOneInstanceProtection()
    {
        if (file_exists($this->getProtectionFilepath())) {
            return true;
        }

        return false;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->checkOneInstanceProtection())
        {
            $output->writeln('<error>One instace of the exporting is running.</error>');
            $output->writeln('<error>If it isn\'t then delete file ' . $this->getProtectionFilepath() . '.</error>');
            return 1;
        }
        $this->setOneInstanceProtection();

        $finishEmail = $input->getArgument('finish-email');

        // File
        $filename = 'testform_export.xml';
        $kernel = $this->getContainer()->get('kernel');
        $exportPath = $kernel->locateResource('@JhekasoftTestformBundle') . '/Resources/export/';
        $filePath = $exportPath . $filename;

        // Create file if it doesn't exist
        if (!file_exists($filePath)) {
            $xml = new \DOMDocument();
            $items = $xml->createElement("items");
            $xml->appendChild($items);
            if (!$xml->save($filePath))
            {
                $output->writeln('<error>XML file writing error</error>');
                return 1;
            }
        }

        // Items
        $repository = $this->getContainer()->get('doctrine')
            ->getRepository('JhekasoftTestformBundle:Testform');
        $testformItems = $repository->findAll();

        $xml = new \DOMDocument();
        $xml->loadXML(file_get_contents($filePath));

        // Get document element
        $root = $xml->documentElement;

        $existsIds = array();
        foreach ($root->childNodes as $node) {
            $existsIds[] = $node->getAttribute('id');
        }

        // Inserting new items
        foreach ($testformItems as $testformItem) {
            if (in_array($testformItem->getId(), $existsIds)) {
                continue;
            }

            $output->writeln('Writing item #' . $testformItem->getId(), '...');

            $item = $xml->createElement("item");
            $item->setAttribute('id', $testformItem->getId());
            $item->setAttribute('ip', $testformItem->getIp());
            $item->setAttribute('ended', (int) $testformItem->getEnded());

            // Answers
            $questions = $this->getContainer()->getParameter('questions');
            $answers = $xml->createElement("answers");
            for ($i = 1; $i <= 5; $i++) {
                $answer = $xml->createElement("answer");
                $answer->setAttribute('question', $questions[$i]);
                $answerText = $xml->createTextNode($testformItem->getAnswer($i));
                $answer->appendChild($answerText);
                $answers->appendChild($answer);
            }
            $item->appendChild($answers);

            // Errorlog
            $errors = $xml->createElement("errors");
            $item->appendChild($answers);
            foreach($testformItem->getErrorlogs() as $errorlog) {
                $error = $xml->createElement("error");
                $errorText = $xml->createTextNode($errorlog);
                $error->appendChild($errorText);
                $errors->appendChild($error);
            }
            $item->appendChild($errors);

            $root->appendChild($item);
        }

        if (!$xml->save($filePath))
        {
            $output->writeln('<error>XML file writing error</error>');
            return 1;
        }

        // Email sending
        if ($finishEmail) {
            $output->writeln("Sending email to the {$finishEmail}...");

            $message = \Swift_Message::newInstance()
                ->setSubject('Jhekasoft Testform - XML Export')
                ->setFrom($this->getContainer()->getParameter('info_email'))
                ->setTo($finishEmail)
                ->setBody('File updated.');
            $this->getContainer()->get('mailer')->send($message);
        }

        $this->unsetOneInstanceProtection();
    }
}
