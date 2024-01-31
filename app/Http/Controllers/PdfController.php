<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pdf;
use Smalot\PdfParser\Parser;

class PdfController extends Controller
{
    public function showForm()
    {
        return view('pdf_upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240', // Max size is 10MB
        ]);

        $pdfFile = $request->file('pdf_file');
        $path = $pdfFile->storeAs('pdfs', $pdfFile->getClientOriginalName(), 'public');

        $pdf = Pdf::create(['path' => $path]);
        

        return redirect()->back()->with('success', 'PDF file uploaded successfully.');
        //when select a pdf file from path need to check whether it contains specific string on that pdf file in laravel
    }

    public function checkStringInPdf(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf',
            'search_string' => 'required|string',
        ]);
        $address = Pdf::all();
        dd($address);

        $pdfPath = $request->file('pdf_file')->getPathname();
        $searchString = $request->input('search_string');

        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();

        // if (strpos($text, $searchString) !== false) {
        //     return '<span style="color: green;">String found in the PDF!</span>';
        // } else {
        //     return '<span style="color: red;">String not found in the PDF!</span>';
        // }
    }

    public function checkAddressInPdf(Request $request)
    {
        
        $pdfs = Pdf::all();

foreach ($pdfs as $pdf) {
    $pdfFilePath = storage_path('app/public/' . $pdf->path); 

    if (file_exists($pdfFilePath)) {
        $parser = new Parser();
        $pdfContent = $parser->parseFile($pdfFilePath);
        $text = $pdfContent->getText();

        // Remove spaces and line breaks from both the address and the text
        $cleanedAddress = str_replace([' ', "\r", "\n"], '', $pdf->address);
        $cleanedText = str_replace([' ', "\r", "\n"], '', $text);


        if (strpos($cleanedText, $cleanedAddress) !== false) {
            $pdf->update(['check_address' => 'Correct']);
        } else {
            $pdf->update(['check_address' => 'Incorrect']);
        }
    } else {
        // Handle the case where the file doesn't exist
        $pdf->update(['check_address' => 'File Not Found']);
    }
}

dd($pdfs);

        // $pdfPath = $request->file('pdf_file')->getPathname();
        // $searchString = $request->input('search_string');

        // $parser = new Parser();
        // $pdf = $parser->parseFile($pdfPath);
        // $text = $pdf->getText();

        // if (strpos($text, $searchString) !== false) {
        //     return '<span style="color: green;">String found in the PDF!</span>';
        // } else {
        //     return '<span style="color: red;">String not found in the PDF!</span>';
        // }
    }
}
