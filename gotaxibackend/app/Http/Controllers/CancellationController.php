<?php

namespace App\Http\Controllers;

use App\CancellationReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CancellationController extends Controller
{
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
        return view('admin.cms.app-cms.cancellation-reason.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { {
            // return $request->all();

            $languages = getLanguages();

            $user_id = Auth::guard('admin')->id();
            $request['created_by'] = $user_id;

            $firstLanguage = $languages->first();
            $firstLanguageReasonKey = 'reason_' . $firstLanguage->id;

            $reason = CancellationReason::create([
                'language_id' => $firstLanguage->id,
                'reason' => $request->input($firstLanguageReasonKey),
                'created_by' => $request['created_by'],
                'parent_id' => 0,
                'type' => $request->type
            ]);

            foreach ($languages as $language) {
                // Skip the first language as it is already created
                if ($language->id == $firstLanguage->id) {
                    continue;
                }

                $reasonKey = 'reason_' . $language->id;
                if ($request->filled($reasonKey)) {
                    $reason->translations()->create([
                        'language_id' => $language->id,
                        'reason' => $request->input($reasonKey),
                        'created_by' => $request['created_by'],
                        'parent_id' => $reason->id,
                        'type' => $request->type
                    ]);
                }
            }

            return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('cancellation_reason_saved'));
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
        $reason = CancellationReason::with('translations')->where('id', $id)->firstOrFail();

        return view('admin.cms.app-cms.cancellation-reason.edit', get_defined_vars());
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
        $user_id = Auth::guard('admin')->id();
        $cancellationReason = CancellationReason::with('translations')->find($id);

        $languages = getLanguages();

        $firstLanguage = $languages->first();
        $firstLanguageReasonKey = 'reason_' . $firstLanguage->id;

        $cancellationReason->update([
            'reason' => $request->input($firstLanguageReasonKey),
            'updated_by' => $user_id,
            'type' => $request->type
        ]);

        foreach ($languages as $language) {
            // Skip the first language as it is already created
            if ($language->id == $firstLanguage->id) {
                continue;
            }

            $reasonKey = 'reason_' . $language->id;
            if ($request->filled($reasonKey)) {
                $cancellationReason->translations()->updateOrCreate([
                    'language_id' => $language->id,
                    'reason' => $request->input($reasonKey),
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'parent_id' => $cancellationReason->id,
                    'type' => $request->type
                ]);
            }
        }

        return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('cancellation_reason_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cancellationReason = CancellationReason::with('translations')->find($id);
        $cancellationReason->translations()->delete();

        $cancellationReason->delete();

        return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('cancellation_reason_deleted'));
    }
}
