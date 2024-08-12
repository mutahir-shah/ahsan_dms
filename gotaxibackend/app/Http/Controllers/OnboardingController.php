<?php

namespace App\Http\Controllers;

use App\Language;
use App\Onboarding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
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
        return view('admin.cms.app-cms.onboarding.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $languages = getLanguages();

        // Find the current maximum step value
        $currentMaxStep = Onboarding::max('step');
        $nextStep = $currentMaxStep ? $currentMaxStep + 1 : 1;

        $firstLanguageId = getLanguages()->first()->id;

        // return $firstLanguageId;

        $title = $request->input("onboarding_user_title" . $firstLanguageId);
        $description = $request->input("onboarding_user_description" . $firstLanguageId);


        $onboarding_image = NULL;
        //rider onboarding image
        if ($request->hasFile('onboarding_image')) {
            $onboarding_image = $request->onboarding_image->store('website');
            $onboarding_image = asset('storage/' . $onboarding_image);
            // Setting::set('onboarding_user_image1', $onboarding_user_image1);
        }

        if (!empty($title) && !empty($description)) {
            $data = [
                'language_id' => $firstLanguageId,
                'title' => $title,
                'description' => $description,
                'type' => $request->input("type"),
                'parent_id' => 0,
                'step' => $nextStep,
                'image' => $onboarding_image 
            ];

            $onboarding = Onboarding::create($data);
        }

        foreach ($languages as $language) {
            $titleKey = 'onboarding_user_title' . $language->id;
            $descriptionKey = 'onboarding_user_description' . $language->id;

            $title = $request->has($titleKey) ? $request->{$titleKey} : null;
            $description = $request->has($descriptionKey) ? $request->{$descriptionKey} : null;

            if ($title || $description) {
                $translation = $onboarding->translations()->firstOrNew([
                    'language_id' => $language->id,
                ]);

                $translation->name = $title;
                $translation->description = $description;
                $translation->save();
            }
        }

        return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('Onboarding data saved successfully!'))->with('activeTab', 'onboarding');
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
        $onboarding = OnBoarding::with('translations')->where('id', $id)->first();
        return view('admin.cms.app-cms.onboarding.edit', get_defined_vars());
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
        // return $request->all();
        $languages = getLanguages();
        $onboarding = Onboarding::where('id', $id)->first();
        // return $onboarding;

        $firstLanguageId = $languages->first()->id;
        // return $firstLanguageId;

        $title = $request->input("onboarding_user_title" . $firstLanguageId);
        $description = $request->input("onboarding_user_description" . $firstLanguageId);

        if (!empty($title) && !empty($description)) {
            $data = [
                'title' => $title,
                'description' => $description,
                'type' => $request->input("type"),
            ];

            $onboarding->update($data);
        }

        //rider onboarding image
        if ($request->hasFile('onboarding_image')) {
            $currentImage = $onboarding->image;
            $currentImagePath = str_replace(asset('storage') . '/', '', $currentImage);
            if ($currentImagePath && Storage::exists('public/' . $currentImagePath)) {
                Storage::delete('public/' . $currentImagePath);
            }
            $onboarding_image = $request->onboarding_image->store('website');
            $onboarding_image = asset('storage/' . $onboarding_image);
            // Setting::set('onboarding_user_image1', $onboarding_user_image1);

            $onboarding->image = $onboarding_image;
            $onboarding->save();
        }

        foreach ($languages as $language) {
            $titleKey = 'onboarding_user_title' . $language->id;
            $descriptionKey = 'onboarding_user_description' . $language->id;

            $title = $request->has($titleKey) ? $request->{$titleKey} : null;
            $description = $request->has($descriptionKey) ? $request->{$descriptionKey} : null;

            if ($title || $description) {
                $translation = $onboarding->translations()->firstOrNew([
                    'language_id' => $language->id,
                ]);

                $translation->name = $title;
                $translation->description = $description;
                $translation->save();
            }
        }

        return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('Onboarding data saved successfully!'))->with('activeTab', 'onboarding');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;

        $onboarding = Onboarding::where('id', $id)->first();

        $currentImage = $onboarding->image;
        $currentImagePath = str_replace(asset('storage') . '/', '', $currentImage);
        if ($currentImagePath && Storage::exists('public/' . $currentImagePath)) {
            Storage::delete('public/' . $currentImagePath);
        }

        $onboarding->translations()->delete();
        $onboarding->delete();

        return redirect()->route('admin.cms.app')->with('flash_success', translateKeyword('Onboarding data delete successfullt'))->with('activeTab', 'onboarding');
    }
}
