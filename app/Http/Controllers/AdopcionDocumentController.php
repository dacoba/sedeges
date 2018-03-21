<?php

namespace App\Http\Controllers;

use App\AdopcionDocument;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
//use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response;

class AdopcionDocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'doc_file' => 'required|mimes:doc,docx,pdf',
        ]);
    }

    protected function getDocumentsTypes()
    {
        return array(
            1 => "Carta Solicitud",
            2 => "Certificado de Antecedentes",
            3 => "Informe Antecedentes",
            4 => "Verificacion Domiciliaria",
            5 => "Certificado Estado Civil"
        );
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $doc_registro = $this->getDocumentsTypes();
        $documents = AdopcionDocument::select('id', 'name')->get();
        return view('create', ['doc_registro' => $doc_registro, 'documents' => $documents]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        if(Input::hasfile('doc_file')){
            $file = Input::file('doc_file');
            AdopcionDocument::create([
                'type' => $request['doc_type'],
                'name' => $file->getClientOriginalName(),
                'size' => $file->getClientSize(),
                'mime' => $file->getClientMimeType(),
                'file' => base64_encode(file_get_contents($file->getRealPath())),
                'solicitud_id' => 1,
            ]);
        }
        $doc_registro = $this->getDocumentsTypes();
        $documents = AdopcionDocument::select('id', 'name')->get();
        return view('create', ['doc_registro' => $doc_registro, 'documents' => $documents]);
    }

    public function show($id)
    {
        $document = AdopcionDocument::find($id);
        $base_64_pdf = $document->file;
        $pdf = base64_decode($base_64_pdf);
//        return response($pdf)
//            ->header('Cache-Control', 'no-cache private')
//            ->header('Content-Description', 'File Transfer')
//            ->header('Content-Type', $document->mime)
//            ->header('Content-length', strlen($pdf))
//            ->header('Content-Disposition', 'attachment; filename=' . $document->name)
//            ->header('Content-Transfer-Encoding', 'binary');
        return response($pdf)->header('Content-Type', $document->mime);
    }

    public function download($id)
    {
        $document = AdopcionDocument::find($id);
        $base_64_pdf = $document->file;
        $pdf = base64_decode($base_64_pdf);
        return response($pdf)
            ->header('Cache-Control', 'no-cache private')
            ->header('Content-Description', 'File Transfer')
            ->header('Content-Type', $document->mime)
            ->header('Content-length', strlen($pdf))
            ->header('Content-Disposition', 'attachment; filename=' . $document->name)
            ->header('Content-Transfer-Encoding', 'binary');
    }

    public function edit(AdopcionDocument $adopcionDocument)
    {
        //
    }

    public function update(Request $request, AdopcionDocument $adopcionDocument)
    {
        //
    }

    public function destroy(AdopcionDocument $adopcionDocument)
    {
        //
    }
}
