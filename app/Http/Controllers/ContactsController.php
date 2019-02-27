<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacts;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    private $model;

    public function __construct(Contacts $contacts)
    {
        $this->model = $contacts;
    }

    public function getAll()
    {
        try{
            $contacts = $this->model->all();
            if(count($contacts) > 0){
                return response()->json($contacts, Response::HTTP_OK);
            } else {
                return response()->json([], Response::HTTP_OK);
            }
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro de conexão com o banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get($id)
    {
        try{
            $contact = $this->model->find($id);
            if(count($contact) > 0){
                return response()->json($contact, Response::HTTP_OK);
            } else {
                return response()->json(null, Response::HTTP_OK);
            }
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro de conexão com o banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required | max:80',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'date' => 'required | date_format: "Y-m-d"'
            ]
        );

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try{
                $contact = $this->model->create($request->all());
                return response()->json($contact, Response::HTTP_CREATED);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro de conexão com o banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }   
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required | max:80',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'date' => 'required | date_format: "Y-m-d"'
            ]
        );

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        } else {
            try{
                $contact = $this->model->find($id)
                    ->update($request->all());
                return response()->json($contact, Response::HTTP_OK);
            } catch (QueryException $exception) {
                return response()->json(['error' => 'Erro de conexão com o banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }  
    }

    public function destroy($id)
    {
        try{
            $contact = $this->model->find($id)
                ->delete();
            return response()->json(null, Response::HTTP_OK);
        } catch (QueryException $exception) {
            return response()->json(['error' => 'Erro de conexão com o banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }

}
