<?php

use Qsardw\Frontend\Configuration\Environments;
use Qsardw\Frontend\Controllers\DatasetsController;
use Qsardw\Frontend\Controllers\IndexController;
use Qsardw\Frontend\Controllers\LoginController;
use Qsardw\Frontend\Controllers\UserController;
use Symfony\Component\HttpFoundation\Response;

$app['datasets.controller'] = $app->share(function () use ($app) {
    return new DatasetsController();
});

$app['index.controller'] = $app->share(function () use ($app) {
    return new IndexController();
});

$app['login.controller'] = $app->share(function () use ($app) {
    return new LoginController();
});

$app['user.controller'] = $app->share(function () use ($app) {
    return new UserController();
});

$app->get('/', 'index.controller:index')->bind('homepage');
$app->get('/datasets/sdf', 'datasets.controller:showFromSdfForm')
    ->bind('sdf_form');
$app->post('/datasets/sdf', 'datasets.controller:createFromSdfFile')
    ->bind('create_from_sdf');
$app->get('/datasets/csv', 'datasets.controller:showFromCsvForm')
    ->bind('csv_form');
$app->post('/datasets/csv', 'datasets.controller:createFromCsvFile')
    ->bind('create_from_csv');
$app->get('/datasets/list', 'datasets.controller:getList')
    ->bind('datasets_list');
$app->get('/datasets/confirmdelete/{id}', 'datasets.controller:showDeleteForm')
    ->bind('dataset_deletion_confirm');
$app->get('/datasets/delete/{id}', 'datasets.controller:deleteDataset')
    ->bind('dataset_deletion');
$app->get('/datasets/review/{id}/clean', 'datasets.controller:reviewDatasetCleanMolecules')
    ->bind('dataset_review_clean');
$app->get('/datasets/review/{id}/discarded', 'datasets.controller:reviewDatasetDiscardedMolecules')
    ->bind('dataset_review_discarded');
$app->get('/datasets/review/{id}/toreview', 'datasets.controller:reviewDatasetMoleculesToReview')
    ->bind('dataset_review_molecules_to_review');
$app->get('/datasets/review/{id}/multiple/{position}', 'datasets.controller:reviewDatasetMultipleMolecules')
    ->bind('dataset_review_multiple_molecules');
$app->get('/datasets/review/{id}/clean/{moleculeId}/{position}', 'datasets.controller:cleanMolecule')
    ->bind('dataset_clean_molecule');
$app->get('/datasets/review/{id}/deleted', 'datasets.controller:reviewDatasetDeleted')
    ->bind('dataset_review_deleted_molecules');
$app->get('/datasets/review/{id}/duplicates/{inchiKey}', 'datasets.controller:reviewDatasetInchiKeyDuplicates')
    ->bind('dataset_review_dataset_duplicates');
$app->get('/datasets/{id}/sdf', 'datasets.controller:getSdfFile')
    ->bind('dataset_get_sdffile');
$app->get('/login', 'login.controller:loginForm')
    ->bind('login');
$app->get('/user/profile', 'user.controller:profile')
    ->bind('user_profile');

$app->error(function (\Exception $ex, $code) use ($app) {
    $app['logger']->debug($ex->getMessage());
    switch ($code) {
        case 404:
            $message = "The page you are looking for doesn't exist";
            break;
        default:
            $message = "Something went wrong, please contact system administrator";
            break;
    }

    if (APP_ENVIRONMENT === Environments::DEVELOPMENT) {
        $templateData = array(
            'message' => $message,
            'exceptionMessage' => $ex->getMessage()
        );
    } else {
        $templateData = array(
            'message' => $message
        );
    }
    $content = $app['twig']->render('error.twig', $templateData);

    return new Response($content, $code);
});
