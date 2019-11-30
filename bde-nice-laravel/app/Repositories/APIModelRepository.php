<?php

namespace App\Repositories;


use App\ApiModelHydrator;
use App\Gestion\APIRequestGestion;
use App\Gestion\UserAuthApiGestion;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class APIModelRepository
{
    private $token;
    private $className;
    private $apiPath;

    public function __construct($className, $apiPath)
    {
        $this->className = $className;
        $this->apiPath = $apiPath;

        try
        {
            $this->token = UserAuthApiGestion::authenticate();

            if($this->token == null)
                throw new Exception('Couldn\'t get token');
        }
        catch(\Exception $e)
        {
            echo $e->getMessage();
            exit();
        }
    }

    function findAll()
    {
        return ApiModelHydrator::hydrateAll($this->className, APIRequestGestion::get($this->apiPath, $this->token, null));
    }

    function find(array $params)
    {
        return ApiModelHydrator::hydrate($this->className, APIRequestGestion::get($this->apiPath, $this->token, $params)[0]);
    }

    function store(array $params)
    {
        return APIRequestGestion::post($this->apiPath, $this->token, $params);
    }

    function update(array $params)
    {
        APIRequestGestion::put($this->apiPath, $this->token, $params);
    }

    function destroy(array $params)
    {
        APIRequestGestion::delete($this->apiPath, $this->token, $params);
    }

}
