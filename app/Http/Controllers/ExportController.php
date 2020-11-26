<?php

namespace App\Http\Controllers;

use App\Exports\ClientExport;
use App\Exports\FeesExport;
use App\Exports\OfficeExport;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function clients()
    {
        return Excel::download(new ClientExport, 'clients.csv');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function fees()
    {
        return Excel::download(new FeesExport, 'fees.csv');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function offices()
    {
        return Excel::download(new OfficeExport, 'offices.csv');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function users()
    {
        return Excel::download(new UserExport, 'users.csv');
    }
}
