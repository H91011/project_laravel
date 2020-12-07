<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Address;

class AddressController extends Controller
{
    public function list()
    {
        $address = Address::select('company_name', 'lat', 'lng')
                        ->get();
        return response()->json($address, Response::HTTP_OK);
    }

    public function add(Request $request)
    {
        $address = new Address();
        $address->company_name = $request->company_name;
        $address->lng =  $request->lng;
        $address->lat =  $request->lat;
        $address->save();
        return response()->json(['address' => $address], Response::HTTP_CREATED);
    }
}
