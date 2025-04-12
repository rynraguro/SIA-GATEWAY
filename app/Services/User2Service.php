<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class User2Service
{
    use ConsumesExternalService;

    /**
     * The base URI to consume the User2 Service
     * @var string
     */
    public $baseUri;

    /**
     * 
     * @var string
     */

     public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.users2.base_uri');
        $this->secret = config('services.users2.secret');
    }

   /**
    *@return string
    */
    public function obtainUsers2()
    {
        return $this->performRequest('GET', '/users');
    }

    /**
     * 
     * @return string
     */
    public function createUser2($data)
    {
        return $this->performRequest('POST', '/users', $data);
    }

    /**
     * @return string
     */
    public function obtainUser2($id)
    {
        return $this->performRequest('GET', "/users/{$id}");
    }

    /**
     * @return string
     */
    public function editUser2($data, $id)
    {
        return $this->performRequest('PUT', "/users{$id}", $data);
    }

     /**
     * @return string
     */
    public function deleteUser2($id)
    {
        return $this->performRequest('DELETE', "/users/{$id}");
    }

    
}