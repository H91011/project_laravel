<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class CompanyController extends Controller
{
    //
    public function list()
    {
        $company = Company::select('name', 'internet_address')
                          ->get();
        return response()->json($company, Response::HTTP_OK);
    }

    public function add(Request $request)
    {
        $data = file_get_contents($request->internet_address);
        $data = mb_convert_encoding($data, "UTF-8", "auto");
        $company = new Company();
        $company->name = $request->name;
        $company->internet_address =  $request->internet_address;
        $company->html = $data;
        $company->save();
        return response()->json(['company' => $company], Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        Company::where('name', $request->old)
                ->update(['name' => $request->name,
                    'internet_address' => $request->internet_address]);
        return response()->json(Response::HTTP_OK);
    }

    public function get($companyName)
    {
        $company = Company::select()
                          ->where('name', '=', $companyName)
                          ->get();
        return response()->json($company, Response::HTTP_OK);
    }


    public function delete(Request $request)
    {
        Company::where('name', '=', $request->name)
                            ->delete();
        return response()->json("", Response::HTTP_NO_CONTENT);
    }

    public function getHtml($companyName)
    {
        $company = Company::select()
                          ->where('name', '=', $companyName)
                          ->get();
        return $this->repairHtml($company[0]);
    }

    public function repairHtml($company)
    {
        $reg = '/<script src="[^h]/';
        $html = $this->replaceHtml($reg, $company->html, $company->internet_address);

        $reg = '/<link rel="stylesheet" href="[^h]/';
        $html = $this->replaceHtml($reg, $html, $company->internet_address);

        $reg = '/<img src="[^h]/';
        $html = $this->replaceHtml($reg, $html, $company->internet_address);
        return $html;
    }

    public function replaceHtml($reg, $html, $internet_address)
    {
        $keywords = preg_match_all($reg, $html, $matches, PREG_SET_ORDER);
        if ($keywords > 0) {
            $match = substr($matches[0][0], 0, strlen($matches[0][0]) -1);
            $last=  substr($matches[0][0], -1);
            $html = preg_replace("/".$matches[0][0]."/", $match.$internet_address.$last, $html);
        }
        return $html;
    }

    public function saveThumbnail($companyName)
    {
        $client = new Client(['base_uri' => 'http://localhost:3000/']);
        $r = $client->request(
            'POST',
            'thumbnail',
            [
            'form_params' => [
              'url' => 'http://localhost:8000/api/getHtml/company/'.$companyName
           ]
         ]
        );

        return $r->getBody();
    }
}
