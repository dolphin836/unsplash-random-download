<?php

namespace Dolphin\Wang\Unsplash;

use GuzzleHttp\Client;

/**
 * Random Download Unsplash Photo
 * 
 * @author Dolphin Wang <wanghaibing@shein.com>
 * @license BSD-3-Clause
 * @version 1.0.0
 * @link https://blog.haibing.site
 */

class Random
{
    /**
     * Unsplash App Access Key
     * 
     * @var string
     */
    private $access_key;

    /**
     * File Save Dir
     * 
     * @var string
     */
    private $dir;

    /**
     * Unsplash API URL
     * 
     * @var string
     */
    private $server = 'https://api.unsplash.com';

    /**
     * Random Method
     * 
     * @var string
     */
    private $methon = '/photos/random';

    /**
     * Http Client
     * 
     * @var object
     */
    private $guzzle;

    /**
     * Init Library
     * 
     * @param string $access_key Unsplash App Access Key
     * @param string $dir File Save Dir
     */
    public function __construct($access_key, $dir = 'pic')
    {
        $this->access_key = $access_key;

        $this->dir = $dir;

        $this->guzzle = new Client();
    }

    /**
     * Download One Photo
     * 
     * @return string
     */
    public function download()
    {
        $result = $this->guzzle->request('GET', $this->server . $this->methon, [
            'headers' => [
                'Accept-Version' => 'v1',
                'Authorization'  => 'Client-ID ' . $this->access_key
            ],
            'verify' => false
        ]);

        if ($result->getStatusCode() === 200) {
            $data = json_decode($result->getBody()->getContents());
    
            $result = $this->guzzle->request('GET', $data->urls->raw, [
                  'sink' => $this->dir . '/' . $data->id . '.jpg',
                'verify' => false
            ]);
    
            if ($result->getStatusCode() === 200) {
                return $this->response(0, ['id' => $data->id]);
            } else {
                return $this->response(2);
            }
        } else {
            return $this->response(1);
        }
    }

    private function response($status, $data = '')
    {
        $error = [
            '',
            'Request Random Method Failed.',
            'Download Photo Failed.'
        ];

        return [
             'code' => $status,
            'error' => $error[$status],
             'data' => $data
        ];
    }
}
