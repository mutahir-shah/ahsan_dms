<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendPushNotification;
use App\Provider;
use App\ServiceType;
use App\ProviderService;
use App\ProviderDocument;
use anlutro\LaravelSettings\Facade as Setting;
use Exception;
use App\Helpers\Helper;
use App\PackageService;
use App\Package;
use Illuminate\Http\Response;

class PackageAssignResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, $package)
    {
        try {
            $Package = Provider::findOrFail($package);
            $PackageService = PackageService::where('package_id', $package)->with('service_type')->get();
            $ServiceTypes = ServiceType::all();
            return view('admin.package.assign', compact('ServiceTypes', 'PackageService'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.index');
        }
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
    public function store(Request $request, $provider_id)
    {
        $this->validate($request, [
            'service_type' => 'required|exists:service_types,id',
            'service_number' => 'required',
            'service_model' => 'required',
        ]);


        try {

            $ProviderService = ProviderService::where('provider_id', $provider_id)->firstOrFail();
            $ProviderService->update([
                'service_type_id' => $request->service_type,
                'status' => 'offline',
                'service_number' => strtolower($request->service_number),
                'service_model' => $request->service_model,
            ]);

            // Sending push to the provider
            (new SendPushNotification)->DocumentsVerfied($provider_id);

        } catch (ModelNotFoundException $e) {
            ProviderService::create([
                'provider_id' => $provider_id,
                'service_type_id' => $request->service_type,
                'status' => 'offline',
                'service_number' => strtolower($request->service_number),
                'service_model' => $request->service_model,
            ]);
        }

        return redirect()->route('admin.provider.document.index', $provider_id)->with('flash_success', translateKeyword('Provider service type updated successfully!'));
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
    public function edit($provider_id, $id)
    {
        try {
            $Document = ProviderDocument::where('provider_id', $provider_id)
                ->findOrFail($id);

            return view('admin.providers.document.edit', compact('Document'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $provider_id, $id)
    {
        try {
            $Document = ProviderDocument::where('provider_id', $provider_id)
                ->findOrFail($id);
            $Document->update(['status' => 'ACTIVE']);

            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider document has been approved.'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_error', translateKeyword('Provider not found!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($provider_id, $id)
    {
        try {

            $Document = ProviderDocument::where('provider_id', $provider_id)
                ->where('id', $id)
                ->firstOrFail();
            $Document->delete();

            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider document has been deleted'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_error', translateKeyword('Provider not found!'));
        }
    }

    /**
     * Delete the service type of the provider.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function service_destroy(Request $request, $provider_id, $id)
    {
        try {

            $ProviderService = ProviderService::where('provider_id', $provider_id)->firstOrFail();
            $ProviderService->delete();

            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_success', translateKeyword('Provider service has been deleted.'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.provider.document.index', $provider_id)
                ->with('flash_error', translateKeyword('Provider service not found!'));
        }
    }
}
