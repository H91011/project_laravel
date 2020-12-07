<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;

class APIController extends Controller
{
    function getEntityController($entity)
    {
        switch ($entity) {
          case 'company':
            return new CompanyController();
          case 'person':
            return new PersonController();
          case 'address':
            return new AddressController();
      }
    }

    function postProcess(Request $request, $process, $entity)
    {
        $controller = $this->getEntityController($entity);
        return $controller->{$process}($request);
    }

    function getProcess($process, $entity, $entityName)
    {
        $controller = $this->getEntityController($entity);
        if (is_null($entityName)) {
            return $controller->{$process}();
        } else {
            return $controller->{$process}($entityName);
        }
    }
}
