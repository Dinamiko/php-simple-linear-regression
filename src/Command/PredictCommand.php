<?php
declare(strict_types=1);

namespace Dinamiko\SimpleLineaRegression\Command;

use Phpml\ModelManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PredictCommand extends Command
{
    protected function configure()
    {
        $this->setName('predict')
            ->setDescription('Predicts Sales based on media values')
            ->addArgument('media', InputArgument::REQUIRED,
                'Three comma separated values, example: 10,20,30');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $values = explode(',', $input->getArgument('media'));

        $modelManager = new ModelManager();
        $regression = $modelManager->restoreFromFile(__DIR__ . '/../../data/advertising-model.dat');

        $prediction = $regression->predict([$values]);

        $output->writeln($prediction);
    }
}