<?php

namespace App\Http\Controllers;

use App\AppLinks;
use App\CMS;
use App\ContactSetting;
use App\GlobalContactSetting;
use App\Helpers\Helper;
use App\Language;
use App\SocialLink;
use App\WebFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use anlutro\LaravelSettings\Facade as Setting;
use App\CancellationReason;
use App\Document;
use App\Faqs;
use App\Onboarding;
use App\PageContent;
use Illuminate\Support\Facades\Auth;

class CMSController extends Controller
{
    public function webindex()
    {
        // Permissions
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.FAQS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.FAQS'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.FAQS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.FAQS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.APPSETTINGS'));

        $languages = getLanguages();
        $webContents = CMS::all();
        $contactSettings = ContactSetting::all();
        $webFaqs = WebFaq::where('language_id', session('translation'))->get();
        if($webFaqs->isEmpty()){
            $webFaqs = WebFaq::where('language_id', getDefautlLanguage())->get();
        }
        // return $webFaqs;
        $socialLinks = SocialLink::first();
        $appLinks = AppLinks::first();
        $pagesContent = PageContent::all();


        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.WEBSETTINGS'));
        return view('admin.cms.web-cms.index', get_defined_vars());
    }

    public function updateWebContent(Request $request)
    {
        // return $request->all();

        $requestData = $request->all();
        $validatedData = [];
        $rules = [];
        $languages = getLanguages();

        foreach ($languages as $language) {
            $rules["site_title_{$language->name}"] = 'required|string|max:255';
            $rules["site_sub_title_{$language->name}"] = 'required|string';
            $rules["meta_title_{$language->name}"] = 'nullable|string|max:255';
            $rules["meta_keywords_{$language->name}"] = 'nullable|string';
            $rules["meta_description_{$language->name}"] = 'nullable|string|max:160';
            $rules["introduction_text_{$language->name}"] = 'nullable|string|max:1000';
        }

        // Validate the request data against the defined rules
        $validator = Validator::make($requestData, $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get active languages
        $languages = getLanguages();

        foreach ($languages as $language) {
            // Build the array of validated data for CMS update
            $validatedData["site_title_{$language->name}"] = $requestData["site_title_{$language->name}"];
            $validatedData["site_sub_title_{$language->name}"] = $requestData["site_sub_title_{$language->name}"];
            $validatedData["meta_title_{$language->name}"] = $requestData["meta_title_{$language->name}"];
            $validatedData["meta_keywords_{$language->name}"] = $requestData["meta_keywords_{$language->name}"];
            $validatedData["meta_description_{$language->name}"] = $requestData["meta_description_{$language->name}"];
            $validatedData["introduction_text_{$language->name}"] = $requestData["introduction_text_{$language->name}"];

            // Find or create CMS record for each language
            CMS::updateOrCreate(
                ['language_id' => $language->id],
                [
                    'site_title' => $validatedData["site_title_{$language->name}"],
                    'site_sub_title' => $validatedData["site_sub_title_{$language->name}"],
                    'meta_title' => $validatedData["meta_title_{$language->name}"],
                    'meta_keyword' => $validatedData["meta_keywords_{$language->name}"],
                    'meta_description' => $validatedData["meta_description_{$language->name}"],
                    'introduction_text' => $validatedData["introduction_text_{$language->name}"],
                ]
            );
        }

        // Redirect back with a success message or perform any other action
        return redirect()->back()->with('flash_success', translateKeyword('Web content updated successfully!'));
    }

    public function contactUpdate(Request $request)
    {
        // return $request->all();
        $languages = getLanguages();
        $rules = [];

        foreach ($languages as $language) {
            $rules["contact_city_{$language->name}"] = 'required|string|max:255';
            $rules["contact_address_{$language->name}"] = 'required|string|max:255';
        }

        $rules = array_merge($rules, [
            'contact_number' => 'required|string|max:255',
        ]);

        // Validate the request data against the defined rules
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // If validation passes, proceed to store or update the data
        $data = $request->all();

        // Determine if contact_number_show is checked
        $contactNumberShow = $request->has('contact_number_show') ? 1 : 0;

        // Store or update contact settings for each language
        foreach ($languages as $language) {
            $languageId = $language->id;
            ContactSetting::updateOrCreate(
                ['language_id' => $languageId],
                [
                    'contact_city' => $data["contact_city_{$language->name}"],
                    'contact_address' => $data["contact_address_{$language->name}"],
                ]
            );
        }

        Setting::set('contact_number_show', $request->has('contact_number_show') ? 1 : 0);

        Setting::set('contact_number', $request->contact_number);

        Setting::save();

        return redirect()->back()->with('flash_success', translateKeyword('Contact settings updated successfully.'));
    }

    public function updateWebFaqs(Request $request)
    {
        // Validate input allowing nullable fields
        $validatedData = $request->validate([
            'faqs.*.*.question' => 'nullable|string',
            'faqs.*.*.answer' => 'nullable|string',
        ]);

        // Fetch languages
        $languages = getLanguages();

        // Process and store FAQs for each language
        foreach ($languages as $language) {
            if (isset($validatedData['faqs'][$language->id])) {
                foreach ($validatedData['faqs'][$language->id] as $index => $faq) {
                    // Only create or update a record if either question or answer is not null
                    if (!is_null($faq['question']) || !is_null($faq['answer'])) {
                        // Check if the FAQ already exists
                        $existingFaq = WebFaq::where('language_id', $language->id)
                            ->where('question_index', $index)
                            ->first();

                        if ($existingFaq) {
                            // Update the existing FAQ
                            $existingFaq->update([
                                'question' => $faq['question'],
                                'answer' => $faq['answer'],
                                'question_index' => $index, // Ensure question_index is updated
                            ]);
                        } else {
                            // Create a new FAQ
                            WebFaq::create([
                                'question' => $faq['question'],
                                'answer' => $faq['answer'],
                                'language_id' => $language->id,
                                'question_index' => $index, // Ensure question_index is set
                            ]);
                        }
                    }
                }
            }
        }
        return redirect()->back()->with('flash_success', translateKeyword('FAQs saved successfully!'));
    }

    public function updateSocialLinks(Request $request)
    {
        // Validate the form data
        $request->validate([
            'f_f_link' => 'nullable|url',
            'f_i_link' => 'nullable|url',
            'f_l_link' => 'nullable|url',
            'f_t_link' => 'nullable|url',
            'f_y_link' => 'nullable|url',
        ]);

        $socialLink = SocialLink::firstOrNew(['id' => 1]);

        $socialLink->facebook = $request->input('f_f_link');
        $socialLink->instagram = $request->input('f_i_link');
        $socialLink->linkedin = $request->input('f_l_link');
        $socialLink->twitter = $request->input('f_t_link');
        $socialLink->youtube = $request->input('f_y_link');

        $socialLink->save();

        return redirect()->back()->with('flash_success', translateKeyword('Social links updated successfully.'));
    }

    public function updateAppLinks(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'f_u_url' => 'required|url',
            'f_p_url' => 'required|url',
            'user_store_link_ios' => 'required|url',
            'driver_store_link_ios' => 'required|url',
        ]);

        // Create or update the record in the database
        $appLink = AppLinks::firstOrNew(['id' => 1]); // Assuming you only have one set of app links
        $appLink->f_u_url = $request->input('f_u_url');
        $appLink->f_p_url = $request->input('f_p_url');
        $appLink->user_store_link_ios = $request->input('user_store_link_ios');
        $appLink->driver_store_link_ios = $request->input('driver_store_link_ios');
        $appLink->save();

        return redirect()->back()->with('flash_success', translateKeyword('App links updated successfully'));
    }

    public function updateWebMedia(Request $request)
    {
        if ($request->hasFile('site_logo')) {
            $site_logo = $request->site_logo->store('website');
            $site_logo = asset('storage/' . $site_logo);
            Setting::set('site_logo', $site_logo);
        }

        if ($request->hasFile('site_icon')) {
            $site_icon = $request->site_icon->store('website');
            $site_icon = asset('storage/' . $site_icon);
            Setting::set('site_icon', $site_icon);
        }

        if ($request->hasFile('connexi_booking_form_image')) {
            $connexi_booking_form_image = $request->connexi_booking_form_image->store('website');
            $connexi_booking_form_image = asset('storage/' . $connexi_booking_form_image);
            Setting::set('connexi_booking_form_image', $connexi_booking_form_image);
        }

        if ($request->hasFile('booking_form_image')) {
            $booking_form_image = $request->booking_form_image->store('website');
            $booking_form_image = asset('storage/' . $booking_form_image);
            Setting::set('booking_form_image', $booking_form_image);
        }

        if ($request->hasFile('advantage_image_1')) {
            $advantage_image_1 = $request->advantage_image_1->store('website');
            $advantage_image_1 = asset('storage/' . $advantage_image_1);
            Setting::set('advantage_image_1', $advantage_image_1);
        }

        if ($request->hasFile('advantage_image_2')) {
            $advantage_image_2 = $request->advantage_image_2->store('website');
            $advantage_image_2 = asset('storage/' . $advantage_image_2);
            Setting::set('advantage_image_2', $advantage_image_2);
        }

        if ($request->hasFile('call_us_image')) {
            $call_us_image = $request->call_us_image->store('website');
            $call_us_image = asset('storage/' . $call_us_image);
            Setting::set('call_us_image', $call_us_image);
        }

        if ($request->hasFile('f_mainBanner')) {
            $f_mainBanner = $request->f_mainBanner->store('website');
            $f_mainBanner = asset('storage/' . $f_mainBanner);
            Setting::set('f_mainBanner', $f_mainBanner);
        }

        if ($request->hasFile('faq_image')) {
            $faq_image = $request->faq_image->store('website');
            $faq_image = asset('storage/' . $faq_image);
            Setting::set('faq_image', $faq_image);
        }

        if ($request->hasFile('blogs_image')) {
            $blogs_image = $request->blogs_image->store('website');
            $blogs_image = asset('storage/' . $blogs_image);
            Setting::set('blogs_image', $blogs_image);
        }

        if ($request->hasFile('testinomial_image')) {
            $testinomial_image = $request->testinomial_image->store('website');
            $testinomial_image = asset('storage/' . $testinomial_image);
            Setting::set('testinomial_image', $testinomial_image);
        }

        if ($request->hasFile('mockup_one')) {
            $mockup_one = $request->mockup_one->store('website');
            $mockup_one = asset('storage/' . $mockup_one);
            Setting::set('mockup_one', $mockup_one);
        }

        if ($request->hasFile('mockup_two')) {
            $mockup_two = $request->mockup_two->store('website');
            $mockup_two = asset('storage/' . $mockup_two);
            Setting::set('mockup_two', $mockup_two);
        }

        if ($request->hasFile('website_login')) {
            $website_login = $request->website_login->store('website');
            $website_login = asset('storage/' . $website_login);
            Setting::set('website_login', $website_login);
        }

        if ($request->hasFile('website_register')) {
            $website_register = $request->website_register->store('website');
            $website_register = asset('storage/' . $website_register);
            Setting::set('website_register', $website_register);
        }

        if ($request->hasFile('slider_image1')) {
            $slider_image1 = $request->slider_image1->store('website');
            $slider_image1 = asset('storage/' . $slider_image1);
            Setting::set('slider_image1', $slider_image1);
        }

        if ($request->hasFile('slider_image2')) {
            $slider_image2 = $request->slider_image2->store('website');
            $slider_image2 = asset('storage/' . $slider_image2);
            Setting::set('slider_image2', $slider_image2);
        }

        if ($request->hasFile('slider_image3')) {
            $slider_image3 = $request->slider_image3->store('website');
            $slider_image3 = asset('storage/' . $slider_image3);
            Setting::set('slider_image3', $slider_image3);
        }

        if ($request->hasFile('slider_image4')) {
            $slider_image4 = $request->slider_image4->store('website');
            $slider_image4 = asset('storage/' . $slider_image4);
            Setting::set('slider_image4', $slider_image4);
        }

        if ($request->hasFile('slider_image5')) {
            $slider_image5 = $request->slider_image5->store('website');
            $slider_image5 = asset('storage/' . $slider_image5);
            Setting::set('slider_image5', $slider_image5);
        }

        if ($request->hasFile('admin_panel')) {
            $admin_panel = $request->admin_panel->store('website');
            $admin_panel = asset('storage/' . $admin_panel);
            Setting::set('admin_panel', $admin_panel);
        }

        Setting::set('video_on_web', $request->has('video_on_web') ? 1 : 0);

        if ($request->hasFile('home_page_video')) {
            $home_page_video = $request->home_page_video->store('website');
            $home_page_video = asset('storage/' . $home_page_video);
            Setting::set('home_page_video', $home_page_video);
        }

        Setting::save();

        return redirect()->back()->with('flash_success', translateKeyword('Site Media updated successfully'));
    }

    public function updateWebColor(Request $request)
    {
        if ($request->has('site_color')) {
            Setting::set('site_color', $request->site_color);
        }

        Setting::save();

        return redirect()->back()->with('flash_success', translateKeyword('Site Color updated successfully'));
    }

    public function updateGoogleMap(Request $request)
    {
        if ($request->has('latitude')) {
            Setting::set('latitude', $request->latitude);
        }
        if ($request->has('longitude')) {
            Setting::set('longitude', $request->longitude);
        }
        if ($request->has('map_contact_page')) {
            Setting::set('map_contact_page', $request->map_contact_page);
        }
        if ($request->has('map_key')) {
            Setting::set('map_key', $request->map_key);
        }
        Setting::save();

        return redirect()->back()->with('flash_success', translateKeyword('Google Settings updated successfully'));
    }


    public function updatePagesContent(Request $request)
    {
        // Identify which form was submitted
        $formType = $request->get('form_type'); // Assuming you have a hidden input 'form_type' in each form

        // Fetch all languages from the database
        $languages = getLanguages();

        // Process data based on form type
        switch ($formType) {
            case 'privacy':
                foreach ($languages as $language) {
                    if ($request->privacy_content[$language->id] != '') {
                        PageContent::updateOrCreate(
                            ['language_id' => $language->id],
                            ['privacy_content' => $request->privacy_content[$language->id]]
                        );
                    }
                }
                break;

            case 'terms':
                foreach ($languages as $language) {
                    if ($request->terms_content[$language->id] != '') {
                        PageContent::updateOrCreate(
                            ['language_id' => $language->id],
                            ['terms_content' => $request->terms_content[$language->id]]
                        );
                    }
                }
                break;

            case 'driver':
                foreach ($languages as $language) {
                    if ($request->driver_content[$language->id] != '') {
                        PageContent::updateOrCreate(
                            ['language_id' => $language->id],
                            ['driver_content' => $request->driver_content[$language->id]]
                        );
                    }
                }
                break;

            case 'about':
                foreach ($languages as $language) {
                    if ($request->about_content[$language->id] != '') {
                        PageContent::updateOrCreate(
                            ['language_id' => $language->id],
                            ['about_content' => $request->about_content[$language->id]]
                        );
                    }
                }
                break;

            default:
                // Handle unexpected form type or return an error response
                session()->put('flash_error', 'Unknown form type submitted.');
                return response()->json(['error' => 'Unknown form type submitted.'], 400);
        }

        // session()->put('flash_success', 'Settings Updated Successfully');
        // return response()->json(['success' => 'Settings updated successfully.']);
        return redirect()->back()->with('flash_success', translateKeyword('Web content updated successfully!'));
    }



    public function appindex()
    {
        $user_id = Auth::guard('admin')->id();
        $add_permission = Helper::CheckPermission(config('const.ADD'), config('const.FAQS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.FAQS'));
        $delete_permission = Helper::CheckPermission(config('const.DELETE'), config('const.FAQS'));
        $data_permission = Helper::CheckPermission(config('const.DATA'), config('const.FAQS'));
        $edit_permission = Helper::CheckPermission(config('const.EDIT'), config('const.APPSETTINGS'));


        $defaultLanguage = Language::where('is_default', 1)->first();

        $data = $this->getCancellationReasons($data_permission);

        $cancellationReasons = $data['cancellationReasons'];
        $faqs = $data['faqs'];


        $documents = Document::orderBy('created_at', 'desc')
            ->when($data_permission != 1, function ($query) use ($user_id) {
                return $query->where('created_by', $user_id);
            })
            ->get();

        $boardings = Onboarding::where('language_id', session('translation'))->get();
        // return $boardings;

        // return $providerBoardings;

        return view('admin.cms.app-cms.index', get_defined_vars());
    }

    public function getCancellationReasons($data_permission)
    {
        $user_id = Auth::guard('admin')->id();
        $defaultLanguage = Language::where('is_default', 1)->first();

        if ($data_permission == 1) {
            $faqs = Faqs::where('language_id', session('translation'))->orderBy('created_at', 'desc')->get();

            // Query for cancellation reasons
            $cancellationReasons = CancellationReason::where('language_id', session('transation'))->get();
            if ($cancellationReasons->isEmpty()) {
                $cancellationReasons = CancellationReason::where('language_id', $defaultLanguage->id)->get();
            }
        } else {
            $faqs = Faqs::where('language_id', session('translation'))->orderBy('created_at', 'desc')->where('created_by', $user_id)->get();
            $cancellationReasons = CancellationReason::where('language_id', session('transation'))->where('created_by', $user_id)->get();
            if ($cancellationReasons->isEmpty()) {
                $cancellationReasons = CancellationReason::where('language_id', $defaultLanguage->id)->where('created_by', $user_id)->get();
            }
        }

        return [
            'cancellationReasons' => $cancellationReasons,
            'faqs' => $faqs
        ];
    }

    public function updateProviderOnboarding(Request $request)
    {
        // return $request->all();
        $languages = getLanguages();
        $type = "DRIVER";

        $firstLanguage = $languages->first();
        $firstLanguageId = $firstLanguage->id;

        for ($step = 1; $step <= 5; $step++) {
            // Update or create the primary record for the first language
            $primaryOnboarding = Onboarding::updateOrCreate(
                [
                    'language_id' => $firstLanguageId, // Primary language ID
                    'parent_id' => 0,
                    'type' => $type,
                    'step' => $step // Ensure step is considered
                ],
                [
                    'title' => $request->input("onboarding_driver_title{$step}_{$firstLanguageId}"),
                    'description' => $request->input("onboarding_driver_description{$step}_{$firstLanguageId}")
                ]
            );

            // Loop through the languages to update or create translations
            foreach ($languages as $language) {
                $languageId = $language->id;

                // Skip the primary language since it's already created
                if ($languageId == $firstLanguageId) {
                    continue;
                }

                // Get the title and description for the current language
                $translatedTitle = $request->input("onboarding_driver_title{$step}_{$languageId}");
                $translatedDescription = $request->input("onboarding_driver_description{$step}_{$languageId}");

                // Skip if both title and description are empty for the translation
                if (empty($translatedTitle) && empty($translatedDescription)) {
                    continue;
                }

                // Update or create the translated record
                Onboarding::updateOrCreate(
                    [
                        'language_id' => $languageId,
                        'parent_id' => $primaryOnboarding->id,
                        'type' => $type,
                        'step' => $step // Ensure step is considered
                    ],
                    [
                        'title' => $translatedTitle,
                        'description' => $translatedDescription
                    ]
                );
            }
        }

        return redirect()->back()->with('flash_success', translateKeyword('Provider boardings updated successfully.'));
    }

    public function updateCancellationReason(Request $request){
        Setting::set('cancel_reason', $request->has('cancel_reason') ? 1 : 0);
        Setting::save();

        return redirect()->back()->with('flash_success', translateKeyword('Cancellation Reason Updated'));
    }
}
