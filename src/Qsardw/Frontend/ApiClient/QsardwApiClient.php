<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Qsardw\Frontend\ApiClient;

use GuzzleHttp\Client;

/**
 * Base QSARDW Web services API client
 *
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class QsardwApiClient
{
    /**
     * HTTP Client for REST API
     * @var \GuzzleHttp\Client
     */
    protected $client;
    
    /**
     * Name or IP address of the host
     * @var string
     */
    protected $host;
    
    /**
     * HTTP port to connect to
     * @var string
     */
    protected $port;
    
    public function __construct($host = 'localhost', $port = '8080')
    {
        $this->client = new Client();
        $this->host = $host;
        $this->port = $port;
    }
    
    /**
     * Returns the Base Endpoint for the QSARDW API
     * @return string
     */
    protected function getBaseEndpoint()
    {
        return "http://{$this->host}:{$this->port}/qsardw-rest/api/";
    }
    
    /**
     * Calls an endpoint and retrieves a collection. If limit and offset is set
     * it retrieves only the objects required beginning in the required offset
     *
     * @param string $collectionEndpoint
     * @param int $limit
     * @param int $offset
     * @return array
     */
    protected function callAndGetCollection($collectionEndpoint, $limit =  null, $offset = null)
    {
        if ((null === $limit) && (null === $offset)) {
            $apiCallResult = $this->client->get($collectionEndpoint);
        } else {
            $apiCallResult = $this->client->get(
                $collectionEndpoint,
                ['query' => ['limit' => $limit, 'offset' => $offset]]);
        }
        
        return json_decode($apiCallResult->getBody(), true);
    }
    
    /**
     * Performs a simple GET operation
     * @param type $readEndpoint
     * @return type
     */
    protected function read($readEndpoint)
    {
        $apiCallResult = $this->client->put($readEndpoint);
        return json_decode($apiCallResult->getBody(), true);
    }
    
    /**
     * Sends data via PUT to perforn an update
     *
     * @param string $updateEndpoint
     * @param array $data
     */
    protected function update($updateEndpoint, $data = [])
    {
        if (empty($data)) {
            $apiCallResult = $this->client->put($updateEndpoint);
        } else {
            $apiCallResult = $this->client->put($updateEndpoint, ['json' => $data]);
        }
        
        return json_decode($apiCallResult->getBody(), true);
    }
}
