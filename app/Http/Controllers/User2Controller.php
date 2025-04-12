<?php

namespace App\Http\Controllers;

//use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use App\Services\User2Service;

class User2Controller extends Controller
{
    use ApiResponser;

    /**
     * 
     * @var User2Service
     */
    public $user2Service;

    /**
     * 
     * @return void
     */
    public function __construct(User2Service $user2Service){
        $this->user2Service = $user2Service;
    }

    /**
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse($this->user2Service->obtainUsers2()); 
    }
    
    public function add(Request $request){
        return $this->successResponse($this->user2Service->createUser2($request->all(), Response::HTTP_CREATED));
    }

    /**
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->successResponse($this->user2Service->obtainUser2($id));
    }

    /**
     * @return Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        return $this->successResponse($this->user2Service->editUser2($request->all(), $id));
    }

    /**
     * @return Illuminate\Http\Response
     */

     public function delete($id)
     {
        return $this->successResponse($this->user2Service->deleteUser2($id));
     }

}