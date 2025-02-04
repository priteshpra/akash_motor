<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function showForm()
    {
        return view('pdf_form');
    }

    public function generatePDF(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
        ];

        $pdf = Pdf::loadView('pdf_template', $data);
        return $pdf->download('UserDetails.pdf');
    }
}
