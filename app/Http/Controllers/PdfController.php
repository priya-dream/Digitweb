<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pdf;
use Smalot\PdfParser\Parser;
use setasign\Fpdi\Tcpdf\Fpdi;
use setasign\Fpdi\PdfParser\PdfParser;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\PdfParser\Type\PdfString;
use TCPDF;
use setasign\Fpdi\Tcpdf\Tcpdi;

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

                // Specify the page number (adjust as needed)
                $pageNumber = 1;

                // Import the page
                $fpdi = new Fpdi();
                $fpdi->setSourceFile($pdfFilePath);
                $tplId = $fpdi->importPage($pageNumber);

                // Get the size of the imported page
                $size = $fpdi->getTemplateSize($tplId);

                // Define the clipping area (adjust coordinates and dimensions as needed)
                $x = $size['width'] * 0.59;   // X coordinate
                $y = $size['height'] * 0.49;  // Y coordinate
                $width = $size['width'] * 0.59;  // Width
                $height = $size['height'] * 0.63; // Height

                // Extract text from the specified area
                $clippedText = substr($text,  $width ,$height);

                $lines = explode("\n", $clippedText);

                if (count($lines) >= 4) {
                    $line2 = str_replace(' ', '', $lines[1]);
                    $line3 = str_replace(' ', '', $lines[2]);
                    $line4 = str_replace(' ', '', $lines[3]);
                }

                $cleanedAddress = str_replace([' ', "\r", "\n"], '', $pdf->address);
                // $cleanedText = str_replace([' ', "\r", "\n"], '', $clippedText);

                $name = ["Russell Rix","name1","name2"];
                $code = ["LA2 0AJ","code1","code2"];
                $address = "3 & 4 Ashton Barns Ashton with Stodday ebayx6d9hxn Lancashire,Lancaster";
                
                $c = 0;
                $a = 0;
                $b = 0;
                $result = " ";

                foreach ($name as $keyword) {
                    if (stripos($cleanedAddress, str_replace(' ', '', $keyword)) !== false) {
                        $a++;
                    }
                }
                foreach ($code as $keyword) {
                    if (strpos($cleanedAddress, str_replace(' ', '', $keyword)) !== false) {
                        $b++;
                    }
                }

                foreach ($lines as $line) {
                    $line = trim($line);

                    if (strpos($cleanedAddress, $line2)!== false || strpos($cleanedAddress, $line3)!== false || strpos($cleanedAddress, $line4)!== false ) {
                        $c++;
                    }
                }

                if ($a>0 && $b>0 && $c>0 ) {
                    $result = 'Correct';
                }
                if ($a === 0 && $b === 0 && $c === 0) {
                    $result = 'Incorrect';
                } 
                if ($a === 0 && $b === 0 && $c>0) {
                    $result = 'Name and Code missed ';
                } 
                if ($a === 0 && $b>0 && $c>0) {
                    $result = 'Name missed';
                } 
                if ($a>0 && $b === 0 && $c>0) {
                    $result = 'Code missed in address';
                } 
                if ($a>0 && $b === 0 && $c===0) {
                    $result = 'Code and address lines missed';
                } 
                if ($a===0 && $b>0 && $c===0) {
                    $result = 'Name and address lines missed';
                } 
                if ($a>0 && $b>0 && $c===0) {
                    $result = 'Address lines missed ';
                }

                    $pdf->update(['check_address' => $result]);  

                }
             
            else{

                $pdf->update(['check_address' => 'File Not Found']);
            }
        }
        // dd($line);
    }
}
