<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreAddress;
use App\Types\Cep;
use Illuminate\Http\Request;

class StoreAddressController extends Controller
{
    public function get()
    {
        $address = StoreAddress::query()
            ->select('cep', 'street', 'number', 'neighborhood', 'city', 'state', 'latitude', 'longitude')
            ->first();

        return response()
            ->json(compact('address'));
    }

    public function updateOrCreate(Request $request)
    {
        $request->validate([
            'cep' => 'required',
            'street' => 'required',
            'number' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required'
        ]);

        StoreAddress::query()
            ->updateOrCreate([
                'cep' => new Cep($request->cep),
                'street' => $request->street,
                'number' => $request->number,
                'neighborhood' => $request->neighborhood,
                'city' => $request->city,
                'state' => $request->state
            ]);

        return response()
            ->json(['message' => 'Endereço salvo com sucesso!']);
    }

}
