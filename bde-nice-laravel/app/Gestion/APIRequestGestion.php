<?php


namespace App\Gestion;

use Exception;
use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;

class APIRequestGestion
{
    const API_URL = 'http://restapi:3000';

    private static function request($method, $url, $token, $params)
    {
        $client = new GuzzleHttp\Client();

        $getParams = '';

        if(($method == 'GET' || $method == 'DELETE') && isset($params) && !empty($params))
        {
            $i = 1;
            $getParams .= '?';

            foreach ($params as $key => $value) {
                $getParams .= $key . '=' . $value . ($i < count($params) ? '&' : '');
                $i++;
            }
        }

        try
        {
            $request = $client->request(
                $method,
                self::API_URL . $url . $getParams,
                [
                    'form_params'  => $method === 'POST' || $method === 'PUT' ? $params : null,
                    'headers' => ['access-token' => $token]
                ]
            );

            $response = json_decode($request->getBody()->getContents());
            if(!isset($response->{'code'}))
                throw new Exception('404: Cannot reach authentication server.');

            if($response->{'code'} == 200)
            {
                if(isset($response->{'content'}))
                {
                    $content = $response->{'content'};

                    if($content == null)
                        throw new Exception('404: No resource has been found');

                    if(is_array($content))
                    {
                        if(empty($content))
                            throw new Exception('404: No resource has been found');
                    }

                    return $content;
                }

                return null;
            }

            throw new Exception($response->{'message'});
        }
        catch (GuzzleException | \Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
    }

    static function post($url, $token, $params)
    {
        return self::request('POST', $url, $token, $params);
    }

    static function put($url, $token, $params)
    {
        return self::request('PUT', $url, $token, $params);
    }

    static function get($url, $token, $params)
    {
        return self::request('GET', $url, $token, $params);
    }

    static function delete($url, $token, $params)
    {
        return self::request('DELETE', $url, $token, $params);
    }
}
