# Simple Linear Regression
...

### Load Data From CSV
[CsvDataset](https://php-ml.readthedocs.io/en/latest/machine-learning/datasets/csv-dataset/)
```
$dataset = new CsvDataset('dataset.csv', 2, true);
```

### Train and Test Data Split
[Random Split](https://php-ml.readthedocs.io/en/latest/machine-learning/cross-validation/random-split/)
```
$dataset = new RandomSplit($dataset, 0.3, 1234);

// train group
$dataset->getTrainSamples();
$dataset->getTrainLabels();

// test group
$dataset->getTestSamples();
$dataset->getTestLabels();
```

### Train and Predict
```
$samples = [[60], [61], [62], [63], [65]];
$targets = [3.1, 3.6, 3.8, 4, 4.1];

$regression = new SVR(Kernel::LINEAR);
$regression->train($samples, $targets);

$regression->predict([64])
// return 4.03

```

### Error
```
$error = Regression::meanAbsoluteError($testTargets, $predictedTargets);
```

### Persistency
[Persistency](https://php-ml.readthedocs.io/en/latest/machine-learning/model-manager/persistency/)
```
$filepath = '/path/to/store/the/model';
$modelManager = new ModelManager();
$modelManager->saveToFile($classifier, $filepath);

$restoredClassifier = $modelManager->restoreFromFile($filepath);
$restoredClassifier->predict([3, 2]);
```
