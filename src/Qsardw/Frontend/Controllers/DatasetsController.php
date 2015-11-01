<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Qsardw\Frontend\Controllers;

use Qsardw\Frontend\ApiClient\DatasetMolecules;
use Qsardw\Frontend\Data\BeanFactory;
use Qsardw\Frontend\Data\Dataset as DatasetDao;
use Qsardw\Frontend\Data\DatasetProcessedMolecules as ProcessedMoleculesDao;
use Qsardw\Frontend\Data\DatasetRawMolecules as RawMoleculesDao;
use Qsardw\Frontend\Files\FileTypes;
use Qsardw\Frontend\Data\DuplicatedMoleculesStrategy;
use Qsardw\Frontend\Data\MultipleMoleculesStrategy;
use Qsardw\Frontend\Data\ObjectsVisibility;
use Qsardw\Frontend\Application;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for managing datasets
 *
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class DatasetsController extends BaseController
{
    /**
     * Shows the creation from from SDF File
     *
     * @param \Qsardw\Frontend\Application $app
     * @return string
     */
    public function showFromSdfForm(Application $app)
    {
        $multipleMoleculesStrategyDao = new MultipleMoleculesStrategy($app['db']);
        $duplicatedMoleculesStrategyDao = new DuplicatedMoleculesStrategy($app['db']);
        $objectsVisibilityDao = new ObjectsVisibility($app['db']);
        
        $templateData = array(
            'multipleMoleculesStrategies' => $multipleMoleculesStrategyDao->listAll(),
            'duplicatedMoleculesStrategies' => $duplicatedMoleculesStrategyDao->listAll(),
            'objectsVisibility' => $objectsVisibilityDao->listAll()
        );
        
        return $app->twig()->render(
            'datasets/create_sdf.twig',
            $templateData
        );
    }

    public function showFromCsvForm(Application $app)
    {
        $multipleMoleculesStrategyDao = new MultipleMoleculesStrategy($app['db']);
        $duplicatedMoleculesStrategyDao = new DuplicatedMoleculesStrategy($app['db']);
        $objectsVisibilityDao = new ObjectsVisibility($app['db']);

        $templateData = array(
            'multipleMoleculesStrategies' => $multipleMoleculesStrategyDao->listAll(),
            'duplicatedMoleculesStrategies' => $duplicatedMoleculesStrategyDao->listAll(),
            'objectsVisibility' => $objectsVisibilityDao->listAll()
        );

        return $app->twig()->render(
            'datasets/create_csv.html.twig',
            $templateData
        );
    }
    
    /**
     *
     * @param \Qsardw\Frontend\Application $app
     * @return string
     */
    public function createFromSdfFile(Application $app)
    {
        $fileUploaded = $app['request']->files->get('sdf_file');
        $uploadPath = $this->getUploadPath($app);
        $uploadFilename = $this->getUploadFilename('sdf', $app['uploads.config']['prefix']);
        $this->createUploadPath($uploadPath);
        
        $fileUploaded->move($uploadPath, $uploadFilename);
        
        $postParams = $app['request']->request->all();
        
        $dataset = BeanFactory::getDataset();
        $dataset->fromRow($postParams);
        $dataset->setOriginalFile($uploadPath . DIRECTORY_SEPARATOR .$uploadFilename);
        $dataset->setOwner($this->getAuthenticatedUser($app)->getId());
        $dataset->setFileType(FileTypes::SDF_FILE);
        
        $datasetRow = $dataset->toRow();
        unset($datasetRow['owner_name']);
        
        $datasetDao = new DatasetDao($app['db']);
        $datasetDao->save($datasetRow);
        
        return $app->redirect($app['url_generator']->generate('datasets_list'));
    }
    
    
    /**
     * Create a new dataset from a CSV File
     *
     * @param \Qsardw\Frontend\Application $app
     * @return string
     */
    public function createFromCsvFile(Application $app)
    {
        $fileUploaded = $app['request']->files->get('csv_file');
        $uploadPath = $this->getUploadPath($app);
        $uploadFilename = $this->getUploadFilename('csv', $app['uploads.config']['prefix']);
        $this->createUploadPath($uploadPath);

        $fileUploaded->move($uploadPath, $uploadFilename);

        $postParams = $app['request']->request->all();

        $dataset = BeanFactory::getDataset();
        $dataset->fromRow($postParams);
        $dataset->setOriginalFile($uploadPath . DIRECTORY_SEPARATOR .$uploadFilename);
        $dataset->setOwner($this->getAuthenticatedUser($app)->getId());
        $dataset->setFileType(FileTypes::CSV_FILE);

        $datasetRow = $dataset->toRow();
        unset($datasetRow['owner_name']);

        $datasetDao = new DatasetDao($app['db']);
        $datasetDao->save($datasetRow);

        return $app->redirect($app['url_generator']->generate('datasets_list'));
    }
    
    /**
     * Gets the lists page of datasets
     *
     * @param \Qsardw\Frontend\Application $app
     * @return string
     */
    public function getList(Application $app)
    {
        $datasetDao = new DatasetDao($app['db']);
        
        $ownerDatasets = $datasetDao->listByOwner(
            $this->getAuthenticatedUser($app)->getId()
        );
        
        $datasetsList = array();
        foreach ($ownerDatasets as $dataset) {
            $moleculesStatus = $this->getDatasetMoleculesStatus($app, $dataset);
            $datasetsList[] = array_merge($dataset, $moleculesStatus);
        }
        
        $templateData = array(
            'datasets' => $datasetsList,
            'owner' => $this->getAuthenticatedUser($app)->getId()
        );
        
        return $app->twig()->render(
            'datasets/lists.twig',
            $templateData
        );
    }
    
    /**
     * Shows the deletion form of a dataset
     *
     * @param \Qsardw\Frontend\Application $app
     * @param int $id
     * @return string
     */
    public function showDeleteForm(Application $app, $id)
    {
        $datasetDao = new DatasetDao($app['db']);
        $dataset = $datasetDao->read($id);
        
        return $app->twig()->render(
            'datasets/delete_form.twig',
            array(
                'dataset' => $dataset->toRow()
            )
        );
    }
    
    /**
     * Shows the review page for a dataset
     *
     * @param \Qsardw\Frontend\Application $app
     * @param integer $id
     * @return string
     */
    public function reviewDatasetCleanMolecules(Application $app, $id)
    {
        $apiClient = new DatasetMolecules();
        $cleanMolecules = $apiClient->getDatasetCleanMolecules($id);
        
        $datasetDao = new DatasetDao($app['db']);
        $datasetData = $datasetDao->read($id);
        
        $moleculeIds = array();
        foreach ($cleanMolecules['molecules'] as $cleanMolecule) {
            $moleculeIds[] = $cleanMolecule['id'];
        }
        
        return $app->twig()->render(
            'datasets/review_clean_molecules.twig',
            array(
                'dataset' => $datasetData,
                'molecules' => $cleanMolecules['molecules'],
                'moleculeIds' => implode(', ', $moleculeIds),
                'totalMolecules' => $cleanMolecules['totalMolecules']
            )
        );
    }
    
    public function reviewDatasetDiscardedMolecules(Application $app, $id)
    {
        $apiClient = new DatasetMolecules();
        $discardedMolecules = $apiClient->getDatasetDiscardedMolecules($id);
        
        $datasetDao = new DatasetDao($app['db']);
        $datasetData = $datasetDao->read($id);
        
        $moleculeIds = array();
        foreach ($discardedMolecules['molecules'] as $cleanMolecule) {
            $moleculeIds[] = $cleanMolecule['id'];
        }
        
        return $app->twig()->render(
            'datasets/review_discarded_molecules.twig',
            array(
                'dataset' => $datasetData,
                'molecules' => $discardedMolecules['molecules'],
                'moleculeIds' => implode(', ', $moleculeIds),
                'totalMolecules' => $discardedMolecules['totalMolecules']
            )
        );
    }

    public function reviewDatasetDeletedMolecules(Application $app, $id)
    {
        $apiClient = new DatasetMolecules();
        $deletedMolecules = $apiClient->getDatasetDeletedMolecules($id);

        $datasetDao = new DatasetDao($app['db']);
        $datasetData = $datasetDao->read($id);

        $moleculeIds = array();
        foreach ($deletedMolecules['molecules'] as $cleanMolecule) {
            $moleculeIds[] = $cleanMolecule['id'];
        }

        return $app->twig()->render(
            'datasets/review_deleted_molecules.twig',
            array(
                'dataset' => $datasetData,
                'molecules' => $deletedMolecules['molecules'],
                'moleculeIds' => implode(', ', $moleculeIds),
                'totalMolecules' => $deletedMolecules['totalMolecules']
            )
        );
    }
    
    public function reviewDatasetMoleculesToReview(Application $app, $id)
    {
        $apiClient = new DatasetMolecules();
        $moleculesToReview = $apiClient->getDatasetMoleculesToReview($id);
        
        $datasetDao = new DatasetDao($app['db']);
        $datasetData = $datasetDao->read($id);
        
        $moleculeIds = array();
        foreach ($moleculesToReview['molecules'] as $cleanMolecule) {
            $moleculeIds[] = $cleanMolecule['id'];
        }
        
        return $app->twig()->render(
            'datasets/review_molecules_to_review.twig',
            array(
                'dataset' => $datasetData,
                'molecules' => $moleculesToReview['molecules'],
                'moleculeIds' => implode(', ', $moleculeIds),
                'totalMolecules' => $moleculesToReview['totalMolecules']
            )
        );
    }
    
    /**
     * Action to review multiple molecules groups
     *
     * @param Application $app
     * @param integer $id
     * @return string
     */
    public function reviewDatasetMultipleMolecules(Application $app, $id, $position)
    {
        $apiClient = new DatasetMolecules();
        $groups = $apiClient->getDatasetGroups($id);

        if (count($groups) === 0) {
        } else {
            $datasetDao = new DatasetDao($app['db']);
            $groups['dataset'] = $datasetDao->read($id);

            $groupIds = array();
            foreach ($groups['groups'] as $group) {
                $groupIds[] = $group['id'];
            }
            $groups['groupIds'] = implode(', ', $groupIds);
            $groups['currentPosition'] = intval($position);

            if ($groups['currentPosition'] === count($groups['groups'])) {
                $groups['lastPosition'] = true;
            } else {
                $groups['lastPosition'] = false;
            }

            if (array_key_exists($position - 1, $groups['groups'])) {
                $group = $apiClient->getDatasetGroupMolecules($id, $groups['groups'][$position - 1]['id']);
                $groups['currentGroup'] = $group;
            } else {
                var_dump(count($groups['groups']));
                if (count($groups['groups']) === ($position - 1)) {
                    return $app->redirect(
                        $app['url_generator']->generate('dataset_review_multiple_molecules', [
                            'id' => $id,
                            'position' => $position - 1
                        ])
                    );
                }
            }

            return $app->twig()->render(
                'datasets/review_dataset_multiple_molecules.html.twig',
                $groups
            );
        }
    }

    /**
     * Shows the review duplicates from dataset form
     *
     * @param Application $app
     * @param $id
     * @param $inchiKey
     * @return string
     */
    public function reviewDatasetInchiKeyDuplicates(Application $app, $id, $inchiKey)
    {
        $apiClient = new DatasetMolecules();
        $duplicatedMolecules = $apiClient->getDatasetInchiKeyDuplicates($id, $inchiKey);

        $datasetDao = new DatasetDao($app['db']);
        $datasetData = $datasetDao->read($id);
        
        $moleculeIds = array();
        foreach ($duplicatedMolecules['molecules'] as $duplicatedMolecule) {
            $moleculeIds[] = $duplicatedMolecule['id'];
        }

        return $app->twig()->render(
            'datasets/review_dataset_inchikey_duplicates.twig',
            array(
                'dataset' => $datasetData,
                'inchiKey' => $inchiKey,
                'molecules' => $duplicatedMolecules['molecules'],
                'moleculeIds' => implode(', ', $moleculeIds),
                'totalMolecules' => $duplicatedMolecules['totalMolecules']
            )
        );
    }

    /**
     * Set a molecule as a clean molecule
     *
     * @param Application $app
     * @param $id
     * @param $moleculeId
     * @param $position
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function cleanMolecule(Application $app, $id, $moleculeId, $position)
    {
        $apiClient = new DatasetMolecules();
        $apiClient->cleanDatasetMolecule($moleculeId);
        
        return $app->redirect(
            $app['url_generator']->generate('dataset_review_multiple_molecules', [
                'id' => $id,
                'position' => $position
            ])
        );
    }
    
    /**
     * Performs a dataset deletion
     *
     * @param \Qsardw\Frontend\Application $app
     * @param int $id
     * @return string
     */
    public function deleteDataset(Application $app, $id)
    {
        $datasetDao = new DatasetDao($app['db']);
        $datasetDao->delete($id);
        
        return $app->redirect($app['url_generator']->generate('datasets_list'));
    }

    /**
     * Returns a dataset as  a SDF file
     *
     * @param Application $app
     * @param $id
     * @return Response
     */
    public function getSdfFile(Application $app, $id)
    {
        $apiClient = new DatasetMolecules();
        $sdfFileResponse = $apiClient->getSdfFile($id);
        $sdfFile = base64_decode($sdfFileResponse['sdfFileContent']);
         
        $timestamp = date('YmdHi');
        $headers = [
            'Content-Disposition' => 'attachment; filename=dataset_' . $id . '_' . $timestamp . '.sdf',
            'Content-Type' => 'chemical/x-mdl-sdfile'
         ];
         
        $response = new Response($sdfFile, 200, $headers);

        return $response;
    }
    
    protected function getDatasetMoleculesStatus(Application $app, $dataset)
    {
        $moleculesStatus = array(
            'clean' => 0,
            'duplicated' => 0,
            'toreview' => 0,
            'deleted' => 0,
            'multiple' => 0
        );
        
        if ($dataset['status'] === '2') {
            $processedMoleculesDao = new ProcessedMoleculesDao($app['db']);
            $moleculesCounts = $processedMoleculesDao->getStatusCount($dataset['id']);
            
            foreach ($moleculesCounts as $moleculeCount) {
                switch ($moleculeCount['processed_status']) {
                    case '1':
                        $moleculesStatus['clean'] = intval($moleculeCount['num_molecules']);
                        break;
                    case '2':
                        $moleculesStatus['duplicated'] = intval($moleculeCount['num_molecules']);
                        break;
                    case '3':
                        $moleculesStatus['toreview'] = intval($moleculeCount['num_molecules']);
                        break;
                    case '4':
                        $moleculesStatus['deleted'] = intval($moleculeCount['num_molecules']);
                        break;
                }
            }
            
            $rawMoleculesDao = new RawMoleculesDao($app['db']);
            $moleculesCount = $rawMoleculesDao->getStatusCount($dataset['id']);
            
            foreach ($moleculesCount as $moleculeCount) {
                if ($moleculeCount['status'] === '2') {
                    $moleculesStatus['multiple'] = intval($moleculeCount['num_molecules']);
                }
            }
        }
        
        return $moleculesStatus;
    }
    
    /**
     * Gets a random filename to upload a file
     * @param string $fileExtension
     * @return string
     */
    protected function getUploadFilename($fileExtension, $prefix)
    {
        $randomString = uniqid();
        
        return "{$prefix}_{$randomString}.{$fileExtension}";
    }
    
    /**
     * Calculates the upload path for the user
     * @param \Qsardw\Frontend\Application $app
     * @return string
     */
    protected function getUploadPath(Application $app)
    {
        $baseUploadPath = $app['uploads.config']['basePath'];
        $pathParts = array(
            $baseUploadPath,
            $this->getAuthenticatedUser($app)->getId(),
            date('Y'),
            date('m'),
            date('d')
        );
        
        $uploadPath = implode(DIRECTORY_SEPARATOR, $pathParts);
        
        return $uploadPath;
    }
    
    /**
     * Creates the upload path for the user
     * @param string $uploadPath
     */
    protected function createUploadPath($uploadPath)
    {
        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0755, true);
        }
    }
}
