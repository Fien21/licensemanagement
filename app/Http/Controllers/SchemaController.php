<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SchemaController extends Controller
{
    public function index()
    {
        $columns = Schema::getColumnListing('licenses');
        return response()->json($columns);
    }
}
