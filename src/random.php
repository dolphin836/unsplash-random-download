<?php

namespace Dolphin\Wang\Unsplash;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

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
     * Unsplash App Access Key Array
     * 
     * @var array
     */
    private $access_key_arr;

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
     * @param string $access_key_arr Unsplash App Access Key Array
     * @param string $dir File Save Dir
     */
    public function __construct($access_key_arr, $dir = 'pic')
    {
        $this->access_key_arr = $access_key_arr;

        $this->dir = $dir;

        $this->guzzle = new Client();
    }

    /**
     * Random Download One Photo
     * 
     * @return array
     */
    public function rand()
    {
        try {
            $result = $this->guzzle->request('GET', $this->server . $this->methon, [
                'headers' => [
                    'Accept-Version' => 'v1',
                    'Authorization'  => 'Client-ID ' . $this->rand_access_key()
                ],
                'verify' => false
            ]);
        } catch(RequestException $e) {
            return $this->response(3); 
        }

        if ($result->getStatusCode() === 200) {
            $data = json_decode($result->getBody()->getContents());
    
            try {
                $result = $this->guzzle->request('GET', $data->urls->raw, [
                    'sink' => $this->dir . '/' . $data->id . '.jpg',
                  'verify' => false
                ]);
            } catch(RequestException $e) {
                return $this->response(4); 
            }

            if ($result->getStatusCode() === 200) {
                return $this->response(0, ['id' => $data->id]);
            } else {
                return $this->response(2);
            }
        } else {
            return $this->response(1);
        }
    }

    /**
     * Auto Download Photos
     * 
     * @return array
     */
    public function run()
    {
        while(1) {
            $data = $this->rand();

            if ($data['code'] === 0) {
                var_dump('Download Image Success:' . $data['data']['id']);
            } else {
                var_dump($data['error']);
            }
        }
    }

    private function response($status, $data = '')
    {
        $error = [
            '',
            'Request Random Method Failed.',
            'Download Photo Failed.',
            'Request Random Method Exception.',
            'Download Photo Exception.'
        ];

        return [
             'code' => $status,
            'error' => $error[$status],
             'data' => $data
        ];
    }

    private function rand_access_key()
    {
        return $this->access_key_arr[rand(0, count($this->access_key_arr) - 1)];
    }
}
