<?php

namespace App\Http\Controllers;

use App\Imports\LanguageImport;
use App\Jobs\ImportLanguageJob;
use App\Keyword;
use App\Langauge;
use App\Language;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::all();
        return view('admin.language.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return redirect()->back();
        return view('admin.language.create', get_defined_vars());
    }

    public function manageTranslation($id){
        $defaultLanguage = Language::with('keywords')->where('is_default', 1)->first();
        return view('admin.language.manage-translation', get_defined_vars());
    }

    public function updateTranslation(Request $request){
        DB::table('language_keyword')
        ->where('id', $request->id)
        ->update(['translation' => $request->translation]);
        return 'true';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function languageKeywords(Request $request, $id = null)
    {
        // Validation rules for updating an existing language
        if ($id) {
            $validatedData = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'short_name' => [
                    'required',
                    'string',
                    'max:255',
                ]
            ]);

            // Fetch the language with the specified ID
            $language = Language::with('keywords')->find($id);

            if ($language) {
                // Update the language
                $language->name = $request->name;
                $language->short_name = $request->short_name;
                $language->save();
            } else {
                // Handle case where language is not found
                return redirect()->back()->withErrors([translateKeyword('language_not_found')]);
            }
        } else {
            // Validation rules for creating a new language
            $validatedData = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('languages'),
                ],
                'short_name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('languages'),
                ]
            ]);

            // Create a new language
            $language = Language::create([
                'name' => $validatedData['name'],
                'short_name' => $validatedData['short_name'],
            ]);
        }

        // Fetch all keywords
        $keywords = Keyword::all();

        // Return the view with the defined variables
        return view('admin.language.language-keyword', compact('language', 'keywords'));
    }


    public function store(Request $request)
    {
        // Handle AJAX request
        if ($request->ajax()) {
            return $this->handleAjaxRequest($request);
        }

        // Handle regular form submissions
        $languageId = $request->input('language_id');
        $keywordIds = $request->input('keyword_ids');
        $translations = $request->input('translations');

        foreach ($keywordIds as $index => $keywordId) {
            $translation = $translations[$index] ?? null;

            // Save or update translation
            $language = Language::find($languageId);
            if ($language) {
                $language->keywords()->syncWithoutDetaching([
                    $keywordId => ['translation' => $translation]
                ]);
            }
        }

        return redirect(route('admin.language.index'))->with('success', translateKeyword('Translations saved successfully.'));
    }

    private function handleAjaxRequest(Request $request)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'language_id' => 'required|exists:languages,id',
                'keyword_id' => 'required|exists:keywords,id',
                'translation' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Retrieve inputs
            $languageId = $request->input('language_id');
            $keywordId = $request->input('keyword_id');
            $translation = $request->input('translation');

            // Find the language
            $language = Language::findOrFail($languageId);

            // Check if the keyword already exists for this language
            $existingKeyword = $language->keywords()->where('keyword_id', $keywordId)->first();

            if ($existingKeyword) {
                // Update existing translation
                $language->keywords()->updateExistingPivot($keywordId, ['translation' => $translation]);
            } else {
                // Attach new keyword with translation
                $language->keywords()->attach($keywordId, ['translation' => $translation]);
            }

            return response()->json(['message' => translateKeyword('Translations saved successfully.')]);
        } catch (\Exception $e) {
            // Log the error with detailed information
            Log::error('Error saving translation', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['flash_error' => translateKeyword('Internal Server Error')], 500);
        }
    }
    public function changeDefault($id)
    {
        // Find the language with the given ID
        $language = Language::find($id);

        if (!$language) {
            // Handle case where language with $id is not found
            return response()->json(['flash_error' => translateKeyword('language_not_found')], 404);
        }

        // Update the language to be default
        $language->is_default = 1;
        $language->save();

        // Set all other languages' is_default to 0
        Language::where('id', '!=', $id)->update(['is_default' => 0]);

        // Optionally, return the updated language
        return redirect(route('admin.language.index'))->with('flash_success', translateKeyword('Status Changed successfully.'));
    }

    public function changeStatus($id) {
        $language = Language::find($id);

        if (!$language) {
            // Handle case where language with $id is not found
            return response()->json(['flash_error' => translateKeyword('language_not_found')], 404);
        }

        // Ensure there is at least one active language before deactivating
        if ($language->status == 'Active') {
            $activeLanguagesCount = Language::where('status', 'Active')->count();
            if ($activeLanguagesCount <= 1) {
                return redirect(route('admin.language.index'))->with('flash_error', translateKeyword('At least one language must be active.'));
            }
        }

        // Toggle the status
        $language->status = $language->status == 'Active' ? 'Inactive' : 'Active';
        $language->save();

        return redirect(route('admin.language.index'))->with('flash_success', translateKeyword('Status changed successfully.'));
    }

    public function languageImport(Request $request)
    {
        // Validate the request
        $request->validate([
            'import_file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Handle file upload
        if ($request->hasFile('import_file')) {
            $file = $request->file('import_file');
            $filePath = $file->store('imports'); // Store the file in the 'imports' directory

            try {
                // Dispatch the job
                ImportLanguageJob::dispatch($filePath);

                // Redirect back with success message
                return redirect()->back()->with('flash_success', translateKeyword('imported successfully-import is running'));
            } catch (\Exception $e) {
                // Handle exceptions or errors during dispatch
                return redirect()->back()->with('flash_error', translateKeyword('Error importing file:') . $e->getMessage());
            }
        } else {
            // Handle case where file is not uploaded
            return redirect()->back()->with('flash_error', translateKeyword('No file uploaded'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $language = Language::where('id', $id)->first();
        // return view('admin.language.edit', get_defined_vars());
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
