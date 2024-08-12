<?php

namespace App\Http\Controllers;

use App\WebFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LogService;
use App\Helpers\Helper;
use Exception;

class WebFaqController extends Controller
{
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->middleware('demo', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cms.web-cms.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $languages = getLanguages(); // Assuming this function returns all languages

        try {
            $firstLanguage = $languages->first();
            $firstLanguageQuestionKey = 'question_' . $firstLanguage->id;
            $firstLanguageAnswerKey = 'answer_' . $firstLanguage->id;

            // Create the main FAQ entry
            $faq = WebFaq::create([
                'language_id' => $firstLanguage->id,
                'question' => $data[$firstLanguageQuestionKey] ?? null,
                'answer' => $data[$firstLanguageAnswerKey] ?? null,
                'question_index' => $data['question_index'] ?? 0,
                'parent_id' => 0
            ]);

            // Create translations for other languages
            foreach ($languages as $language) {
                $questionKey = 'question_' . $language->id;
                $answerKey = 'answer_' . $language->id;

                if ($language->id == $firstLanguage->id) {
                    continue;
                }

                if ($request->filled($questionKey) || $request->filled($answerKey)) {
                    $faq->translations()->create([
                        'language_id' => $language->id,
                        'question' => $request->input($questionKey),
                        'answer' => $request->input($answerKey),
                        'question_index' => $data['question_index'] ?? null,
                        'parent_id' => $faq->id,
                    ]);
                }
            }

            // Log success and redirect
            $this->logService->log('WebFaq', 'create', 'FAQ Created.', $faq);
            return redirect()->route('admin.cms.web')->with('flash_success', translateKeyword('Faq Saved Successfully'));
        } catch (\Exception $e) {
            // Handle exception and redirect with error message
            return back()->with('flash_error', translateKeyword('Faqs Not Found'))->withErrors($e->getMessage());
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
        $faqs = WebFaq::with('translations')->findOrFail($id);
        return view('admin.cms.web-cms.faqs.edit', compact('faqs'));
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

        $data = $request->all();
        $languages = getLanguages(); // Assuming this function returns all languages

        try {
            // Find the main FAQ entry
            $faq = WebFaq::findOrFail($id);
            $firstLanguage = $languages->first();
            $firstLanguageQuestionKey = 'question_' . $firstLanguage->id;
            $firstLanguageAnswerKey = 'answer_' . $firstLanguage->id;

            // Update the main FAQ entry
            $faq->update([
                'question' => $data[$firstLanguageQuestionKey] ?? $faq->question,
                'answer' => $data[$firstLanguageAnswerKey] ?? $faq->answer,
                'question_index' => 0,
                ]);

            // Update translations for other languages
            foreach ($languages as $language) {
                $questionKey = 'question_' . $language->id;
                $answerKey = 'answer_' . $language->id;

                if ($language->id == $firstLanguage->id) {
                    continue;
                }

                if ($request->filled($questionKey) || $request->filled($answerKey)) {
                    $translation = $faq->translations()->where('language_id', $language->id)->first();

                    if ($translation) {
                        // Update existing translation
                        $translation->update([
                            'question' => $request->input($questionKey),
                            'answer' => $request->input($answerKey),
                            'question_index' => 0,
                        ]);
                    } else {
                        // Create new translation if it does not exist
                        $faq->translations()->create([
                            'language_id' => $language->id,
                            'question' => $request->input($questionKey),
                            'answer' => $request->input($answerKey),
                            'question_index' => 0,
                            'parent_id' => $faq->id,
                        ]);
                    }
                }
            }

            // Log success and redirect
            $this->logService->log('WebFaq', 'update', 'FAQ Updated.', $faq);
            return redirect()->route('admin.cms.web')->with('flash_success', translateKeyword('Faq Updated Successfully'));
        } catch (\Exception $e) {
            // Handle exception and redirect with error message
            return back()->with('flash_error', translateKeyword('Faq Not Updated'))->withErrors($e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $faq = WebFaq::find($id);
            $this->logService->log('Web Faqs', 'delete', 'Faq Deleted.', $faq);

            $faq->translations()->delete();
            $faq->delete();
            return back()->with('flash_success', translateKeyword('Faq deleted successfully'))->with('activeTab', 'faqs');
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Faqs Not Found'));
        }
    }
}
