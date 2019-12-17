<?php
declare(strict_types=1);

namespace Dinamiko\SimpleLineaRegression\Command;

use Phpml\CrossValidation\RandomSplit;
use Phpml\Dataset\CsvDataset;
use Phpml\Math\Statistic\Correlation;
use Phpml\Metric\Regression;
use Phpml\ModelManager;
use Phpml\Regression\LeastSquares;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TrainCommand extends Command
{
    protected function configure()
    {
        $this->setName('train')
            ->setDescription('Train ML model');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataset = new CsvDataset(__DIR__ . '/../../data/advertising.csv', 3);
        $randomSplit = new RandomSplit($dataset, 0.3, 1234);

        $regression = new LeastSquares();
        $regression->train($randomSplit->getTrainSamples(), $randomSplit->getTrainLabels());

        $modelManager = new ModelManager();
        $modelManager->saveToFile($regression, __DIR__ . '/../../data/advertising-model.dat');

        $output->writeln(sprintf('MAE %s', Regression::meanAbsoluteError(
            $randomSplit->getTestLabels(),
            $regression->predict($randomSplit->getTestSamples())
        )));
    }
}