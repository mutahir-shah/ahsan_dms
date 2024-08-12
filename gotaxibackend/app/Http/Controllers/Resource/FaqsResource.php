<?php

namespace App\Http\Controllers\Resource;

use App\Faqs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Http\Response;
use App\Services\LogService;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class FaqsResource extends Controller
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
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.FAQS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.FAQS'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.FAQS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.FAQS'));

        if ($data_permission == 1) {
            $faqs = Faqs::orderBy('created_at', 'desc')->get();
        } else {
            $faqs = Faqs::orderBy('created_at', 'desc')->where('created_by', $user_id)->get();
        }
        return view('admin.faqs.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.FAQS'));
        if ($add_permission != 1) {
            abort(401);
        }
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:DRIVER,USER',
        ]);

        $data = $request->all();
        $languages = getLanguages();

        // try {
            $user_id = Auth::guard('admin')->id();
            $request['created_by'] = $user_id;

            $firstLanguage = $languages->first();
            $firstLanguageQuestionKey = 'question_' . $firstLanguage->id;
            $firstLanguageAnswerKey = 'answer_' . $firstLanguage->id;

            $faq = Faqs::create([
                'language_id' => $firstLanguage->id,
                'question' => $data[$firstLanguageQuestionKey] ?? null,
                'answer' => $data[$firstLanguageAnswerKey] ?? null,
                'type' => $data['type'],
                'created_by' => $request['created_by'],
                'parent_id' => 0
            ]);

            foreach ($languages as $language) {
                $questionKey = 'question_' . $language->id;
                $answerKey = 'answer_' . $language->id;

                if ($language->id == $firstLanguage->id) {
                    continue;
                }

                if ($request->filled($questionKey) || $request->filled($answerKey)) { // Check if the name field is not empty
                    $translation = $faq->translations()->create([
                        'language_id' => $language->id,
                        'question' => $request->input($questionKey),
                        'answer' => $request->input($answerKey),
                        'type' => $data['type'],
                        'parent_id' => $faq->id,
                        'created_by' => $request['created_by']
                    ]);
                }
            }

            $this->logService->log('Faqs', 'create', 'Faq Created.', $faq);
            return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('Faq Saved Successfully'))->with('activeTab', 'faqs');
        // } catch (Exception $e) {
            // dd($e->getMessage());
            // return back()->with('flash_error', translateKeyword('Faqs Not Found'));
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param Faqs $providerFaqs
     * @return Response
     */
    public function show($id)
    {
        try {
            $view_permission = Helper::CheckPermission(config('const.VIEW'), config('const.FAQS'));
            if ($view_permission != 1) {
                abort(401);
            }
            return Faqs::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Faqs $providerFaqs
     * @return Response
     */
    public function edit($id)
    {
        try {
            $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.FAQS'));
            if ($edit_permission != 1) {
                abort(401);
            }
            $faqs = Faqs::with('translations')->findOrFail($id);
            return view('admin.faqs.edit', compact('faqs'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Faqs $providerFaqs
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required|in:DRIVER,USER',
        ]);

        $data = $request->all();
        $languages = getLanguages();

        // try {
            $user_id = Auth::guard('admin')->id();
            $faq = Faqs::with('translations')->findOrFail($id);

            $firstLanguage = $languages->first();
            $firstLanguageQuestionKey = 'question_' . $firstLanguage->id;
            $firstLanguageAnswerKey = 'answer_' . $firstLanguage->id;

            // Update the FAQ's main fields
            $faq->update([
                'language_id' => $firstLanguage->id,
                'question' => $request->input($firstLanguageQuestionKey),
                'answer' => $request->input($firstLanguageAnswerKey),
                'type' => $data['type'],
                'updated_by' => $user_id,
            ]);


            // Update translations for each language
            foreach ($languages as $language) {
                $questionKey = 'question_' . $language->id;
                $answerKey = 'answer_' . $language->id;

                if ($language->id == $firstLanguage->id) {
                    continue;
                }

                if ($request->filled($questionKey) || $request->filled($answerKey)) {
                    $translation = $faq->translations()->updateOrCreate([
                        'language_id' => $language->id,
                        'question' => $request->input($questionKey),
                        'answer' => $request->input($answerKey),
                        'type' => $data['type'],
                        'parent_id' => $faq->id,
                        'updated_by' => $user_id,
                    ]);
                }
            }

            $this->logService->log('Faqs', 'update', 'Faq Updated.', $faq);
            return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('Faq Updated Successfully'))->with('activeTab', 'faqs');
        // } catch (Exception $e) {
            // return back()->with('flash_error', translateKeyword('Faq Not Found'));
        // }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Faqs $providerFaqs
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $faq = Faqs::find($id);
            $this->logService->log('Faqs', 'delete', 'Faq Deleted.', $faq);

            $faq->translations()->delete();
            $faq->delete();
            return back()->with('flash_success', translateKeyword('Faq deleted successfully'))->with('activeTab', 'faqs');
        } catch (Exception $e) {
            return back()->with('flash_error', translateKeyword('Faqs Not Found'));
        }
    }
}
