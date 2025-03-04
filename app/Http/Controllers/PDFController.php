<?php

namespace App\Http\Controllers;

use App\Models\ProductAddData;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use NumberFormatter;

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
            'pdfCalculate' => $request->input('pdfCalculate'),
            'date' => date('d/m/Y'),
        ];
        $product_id = $request->input('product_id');
        $category_id = $request->input('category_id');
        $created_at = $request->input('pdfDate');
        // dd($created_at);
        $subcat = ProductAddData::leftJoin('sub_categories', 'sub_categories.id', '=', 'products_add_data.subcategory_id')
            ->leftJoin('products', 'products.id', '=', 'products_add_data.product_id')
            ->where('products_add_data.date', $created_at)
            ->where('products_add_data.product_id', $product_id)
            ->where('products_add_data.category_id', $category_id)
            ->where('products_add_data.status', '1')
            ->distinct()
            ->get();
        $groupedSubcat = $subcat->groupBy('subcategory_name');

        $response = $groupedSubcat->map(function ($items, $name) use ($created_at) {
            // Use the first item for fixed fields like `flange_percentage`, `footval`, `typeOption`
            $firstItem = $items->first();

            $dateFilter = $created_at;
            $matchingItem = $items->firstWhere('date', $dateFilter);


            // Consolidate options
            $options = $items->map(function ($item) {
                return [
                    'date' => $item->date,
                    // 'date' => strtotime($item->date),
                    'label' => $item->subcategory_val
                ];
            });

            return [
                'id' => $firstItem->subcategory_id,
                'produc_name' => $firstItem->product_name,
                'label' => $firstItem->subcategory_name,
                'price' => $firstItem->footval,
                'size' => $firstItem->size,
                'typeOption' => $matchingItem->typeOption,
                'flange_percentage' => $firstItem->flange_percentage,
                'flangePriceCal' => $firstItem->footval + ($firstItem->footval * $firstItem->flange_percentage / 100),
                'options' => $options->unique('date')->values()
            ];
        })->values();
        $data['GST'] = \App\Models\Tax::select('gst', 'id')->where('status', '1')->first()['gst'];

        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $data['GSTWord'] = $formatter->format($data['GST']);
        $data['AmountWord'] = $formatter->format($request->input('pdfCalculate'));
        $data['response'] = ($response[0]) ? $response[0] : array();
        $data['randomNumber'] = rand(1000, 9999);
        // dd($data);
        $namePdfFile = $request->input('name') . '_invoice';
        $pdf = Pdf::loadView('pdf_template', $data);
        return $pdf->download($namePdfFile . '.pdf');
    }
}
