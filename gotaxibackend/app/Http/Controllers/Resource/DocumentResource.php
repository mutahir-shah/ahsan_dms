<?php

namespace App\Http\Controllers\Resource;

use App\Document;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Http\Response;
use App\Services\LogService;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class DocumentResource extends Controller
{
    protected $logService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user_id = Auth::guard('admin')->id();
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.USERS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.USERS'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.USERS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.USERS'));

        $documents = Document::orderBy('created_at', 'desc')
            ->when($data_permission != 1, function ($query) use ($user_id) {
                return $query->where('created_by', $user_id);
            })
            ->get();

        // $documents->translations->where('language_id', session('translation'))->first();

        return view('admin.document.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.USERS'));
        if ($add_permission == 0) {
            abort(401);
        }
        return view('admin.document.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Validate base fields
        $this->validate($request, [
            'type' => 'required|in:VEHICLE,DRIVER,USER',
            'expiry_required' => 'required|in:YES,NO'
        ]);

        $data = $request->all();
        $languages = getLanguages();

        try {
            // Set 'created_by' field
            $request['created_by'] = Auth::guard('admin')->id();

            // Get the first language to use for creating the Document
            $firstLanguage = $languages->first();
            $firstLanguageNameKey = 'name_' . $firstLanguage->id; // Corrected to use ID for uniqueness

            // Create Document with the first language's name
            $document = Document::create([
                'name' => $data[$firstLanguageNameKey] ?? null, // Use null coalescing operator to handle missing keys
                'type' => $request->type,
                'expiry_required' => $request->expiry_required,
                'created_by' => $request['created_by'],
            ]);

            // Iterate over all languages to save translations
            foreach ($languages as $language) {
                $nameKey = 'name_' . $language->id;

                if ($request->filled($nameKey)) { // Check if the name field is not empty
                    $translation = $document->translations()->firstOrNew([
                        'language_id' => $language->id,
                    ]);

                    $translation->name = $request->input($nameKey);
                    $translation->save();
                }
            }

            // Log creation and redirect
            $this->logService->log('Documents', 'create', 'Document Created', $document);
            return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('Document Saved Successfully'))->with('activeTab', 'documents');
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Document Not Saved'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param Document $providerDocument
     * @return Response
     */
    public function show($id)
    {
        try {
            $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.USERS'));
            if ($view_permission == 0) {
                abort(401);
            }
            return Document::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Document $providerDocument
     * @return Response
     */
    public function edit($id)
    {
        try {
            $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.USERS'));
            if ($edit_permission == 0) {
                abort(401);
            }
            $document = Document::with('translations')->findOrFail($id);
            return view('admin.document.edit', compact('document'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Document $providerDocument
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required|in:VEHICLE,DRIVER,USER',
            'expiry_required' => 'required|in:YES,NO'
        ]);

        try {
            // Find the document
            $document = Document::findOrFail($id);

            // Update the document attributes
            $document->update([
                'type' => $request->type,
                'expiry_required' => $request->expiry_required,
                'updated_by' => Auth::guard('admin')->id(),
            ]);

            // Update translations
            $languages = getLanguages();
            foreach ($languages as $language) {
                $nameKey = 'name_' . $language->id;

                if ($request->filled($nameKey)) { // Check if the name field exists
                    $translation = $document->translations()->firstOrNew([
                        'language_id' => $language->id,
                    ]);

                    $translation->name = $request->input($nameKey);
                    $translation->save();
                }
            }

            // Log the update action
            $this->logService->log('Documents', 'update', 'Document Updated', $document);

            return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('Document Updated Successfully'))->with('activeTab', 'documents');
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Document Not Found'));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Document $providerDocument
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $document = Document::findOrFail($id);
            $this->logService->log('Documents', 'delete', 'Document Deleted', $document);
            $document->translations()->delete();
            $document->delete();
            return back()->with('flash_success', translateKeyword('Document deleted successfully'))->with('activeTab', 'documents');
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Document Not Found'));
        }
    }
}
