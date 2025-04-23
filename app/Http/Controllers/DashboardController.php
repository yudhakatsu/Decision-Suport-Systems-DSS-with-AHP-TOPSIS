<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class DashboardController extends Controller
{
    public function upload()
    {

        $path = public_path().'/'.'file.xlsx';
        $filename = 'file.xlsx';

        Storage::disk('google')->put($filename, File::get($path));

        return response()->json(['success' => true]);
    }
}
