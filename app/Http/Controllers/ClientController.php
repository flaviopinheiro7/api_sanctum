<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ApiResponses;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        if (!auth()->user()->tokenCan('clients:all')) {
            return ApiResponses::error('Access denied');
        }

        //return all clients
        return ApiResponses::success(Client::all());
    }

    public function store(Request $request)
    {
        // validando inputs
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:clients',
            'phone' => 'required'
        ]);

        // create client
        $client = Client::create($request->all());

        return ApiResponses::success($client);
    }

    public function show(string $id)
    {
        if (!auth()->user()->tokenCan('clients:client')) {
            return ApiResponses::error('Access denied');
        }


        $client = Client::find($id);

        if (!$client) {
            return ApiResponses::notFound('Cliente');
        }

        return ApiResponses::success($client);
    }

    public function update(Request $request, string $id)
    {
        // validando inputs
        $request->validate([
            'name'  => 'required',
            'email' => "required|email|unique:clients,email,$id",
            'phone' => 'required'
        ]);

        $client = Client::find($id);

        if (!$client) {
            return ApiResponses::notFound('Client');
        }

        $client->update($request->all());

        return ApiResponses::success($client);

    }

    public function destroy(string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return ApiResponses::notFound('Client');
        }

        $client->delete();

        return ApiResponses::success([]);
    }


}
