<?php

namespace App\Models\Signature;
use Illuminate\Database\Eloquent\Model;
use Creagia\LaravelSignPad\Concerns\RequiresSignature;
use Creagia\LaravelSignPad\Contracts\CanBeSigned;
use Creagia\LaravelSignPad\Contracts\ShouldGenerateSignatureDocument;
use Creagia\LaravelSignPad\Templates\BladeDocumentTemplate;
use Creagia\LaravelSignPad\Templates\PdfDocumentTemplate;
use Creagia\LaravelSignPad\SignatureDocumentTemplate;
use Creagia\LaravelSignPad\SignaturePosition;

class SigantureModel extends Model implements CanBeSigned, ShouldGenerateSignatureDocument
{
    use RequiresSignature;
    

    public function getSignatureDocumentTemplate(): SignatureDocumentTemplate
    {
        return new SignatureDocumentTemplate(
            outputPdfPrefix: 'document', // optional
            template: new BladeDocumentTemplate('pdf/my-pdf-blade-template'), // Uncomment for Blade template
            template: new PdfDocumentTemplate(storage_path('pdf/template.pdf')), // Uncomment for PDF template
            signaturePositions: [
                 new SignaturePosition(
                     signaturePage: 1,
                     signatureX: 20,
                     signatureY: 25,
                 ),
                 new SignaturePosition(
                     signaturePage: 2,
                     signatureX: 25,
                     signatureY: 50,
                 ),
            ]               
        );
    }

}

?>