<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Person;

class PersonController extends Controller
{
    //
    public function list()
    {
        $person = Person::select()
                          ->get();
        return response()->json($person, Response::HTTP_OK);
    }

    public function add(Request $request)
    {
        $person = new Person();
        $person->name = $request->name;
        $person->last_name = $request->last_name;
        $person->title = $request->title;
        $person->email = $request->email;
        $person->company_name = $request->company_name;
        $person->phone_number = $request->phone_number;
        $person->save();
        return response()->json(['person' => $person], Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        Person::where('email', $request->old)
              ->update(['name' => $request->name,
                        'last_name' => $request->last_name,
                        'title' => $request->title,
                        'email' => $request->email,
                        'company_name' => $request->company_name,
                        'phone_number' => $request->phone_number]);
        return response()->json(Response::HTTP_OK);
    }

    public function get($email)
    {
        $person = Person::select()
                          ->where('email', '=', $email)
                          ->get();
        return response()->json($person, Response::HTTP_OK);
    }

    public function delete(Request $request)
    {
        Person::where('email', '=', $request->email)
                        ->delete();
        return response()->json("",Response::HTTP_NO_CONTENT);
    }
}
