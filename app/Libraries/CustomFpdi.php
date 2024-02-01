<?
namespace App\Libraries;

use setasign\Fpdi\Tcpdf\Fpdi;

class CustomFpdi extends Fpdi
{
    public function getPdfReader()
    {
        return $this->pdfReader;
    }
}

