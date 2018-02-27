<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 27-Feb-18
 * Time: 14:25
 */

namespace AppBundle\Service;


use GuzzleHttp\Client;

class CloseIOService
{
    /**
     * @var Client
     */
    private $client;

    /** @var String */
    private $credentials;

    /** @var array */
    private $header;

    /**
     * @var
     */
    private $uri;

    /**
     * CloseIOService constructor.
     * @param Client $client
     * @param $credentials
     * @param $uri
     */
    public function __construct(Client $client, $credentials, $uri)
    {
        $this->client = $client;
        $this->uri = $uri;
        $this->credentials = $credentials;
        $this->header = ['auth' => [$this->credentials, '']];
    }

    /**
     * @param $orgId
     * @param $emailAddress
     * @param int $limit
     * @return array
     */
    public function findContact(
        $orgId,
        $emailAddress,
        $limit = 200
    )
    {
        $response = $this->client->get(sprintf('%s?organization_id=%s&query=%s&_limit=%s', $this->uri, $orgId, $emailAddress, $limit),
            $this->header
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     *
     */
    public function createContact($company, $emailAddress)
    {
        $body = ['body' => json_encode(
            [
                'name' => $company,
                'contacts'=> [
                    [
                        "emails" => [
                          [
                                "type" => "office",
                                 "email" => $emailAddress
                          ]
                       ]
                   ]
                ]
            ]
        )];

        $postHeader = array_merge($this->header, $body,  ['content-type' => 'application/json']);

        $response = $this->client->post(
            sprintf('%s', $this->uri),
            $postHeader
        );

        return json_decode($response->getBody()->getContents(), true);
    }
}