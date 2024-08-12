<?php

namespace App\Http\Controllers\ProviderResources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Document;
use App\Provider;
use App\ProviderDocument;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $DriverDocuments = Document::driver()->get();

        $provider = Auth::guard('provider')->user();

        $VehicleDocuments = ProviderDocument::with('document', 'vehicle')
            ->where('provider_id', $provider->id)
            ->whereHas('vehicle')
            ->whereHas('document', function ($query) {
                $query->where('type', 'VEHIClE');
            })
            ->get()
            ->groupBy('vehicle.service_model');

        return view('provider.document.index', compact('DriverDocuments', 'VehicleDocuments', 'provider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'document' => 'mimes:jpg,jpeg,png,pdf',
            'vehicle' => 'required'
        ]);
        try {
            $Document = ProviderDocument::where('provider_id', Auth::guard('provider')->user()->id)
                ->where('document_id', $id)
                ->where('vehicle_id', $request->vehicle)
                ->firstOrFail();
            if ($request->expires_at)
                $Document->expires_at = $request->expires_at;

            $Document->url = $request->document->store('provider/documents');
            $Document->status =  'ASSESSING';

            $Document->save();
        } catch (ModelNotFoundException $e) {
            ProviderDocument::create([
                'url' => $request->document->store('provider/documents'),
                'provider_id' => Auth::guard('provider')->user()->id,
                'vehicle_id', $request->vehicle,
                'document_id' => $id,
                'status' => 'ASSESSING',
                'expires_at' => $request->expires_at
            ]);
        }

        Provider::where('id', Auth::guard('provider')->user()->id)
            ->update([
                'status' => 'doc_required'
            ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
