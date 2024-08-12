<?php

namespace App\Http\Controllers;

use App\Provider;
use App\User;
use App\UserDocument;
use App\Document;
use App\Card;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use anlutro\LaravelSettings\Facade as Setting;
use App\BookingRequest;
use App\ContactEnquiry;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Token;

class HomeController extends Controller
{
    protected $UserAPI;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $UserAPI)
    {
        $this->middleware('auth');
        $this->UserAPI = $UserAPI;
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        if (Setting::get('user_verification') == 1) {
            if (request()->user()->status == 'doc_required')
            return redirect()->route('user.profile');
        }

        if (Setting::get('negotiation_module', 0) == 0) {
            $Response = $this->UserAPI->request_status_check()->getData();
            if (empty($Response->data)) {
                $services = $this->UserAPI->services();
                $economy = $this->UserAPI->services()->where('type', 'economy');
                $extra_seat = $this->UserAPI->services()->where('type', 'extra_seat');
                $luxury = $this->UserAPI->services()->where('type', 'luxury');
                $outstation = $this->UserAPI->services()->where('type', 'outstation');
                $road_assistance = $this->UserAPI->services()->where('type', 'road_assistance');
                return view('user.dashboard', compact('services', 'economy', 'extra_seat', 'luxury', 'outstation', 'road_assistance'));
            } else {
                return view('user.ride.waiting')->with('request', $Response->data[0]);
            }
        } else {
            return $this->profile();
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function new_job()
    {
       
        $services = $this->UserAPI->services();
        $economy = $this->UserAPI->services()->where('type', 'economy');
        $extra_seat = $this->UserAPI->services()->where('type', 'extra_seat');
        $luxury = $this->UserAPI->services()->where('type', 'luxury');
        $outstation = $this->UserAPI->services()->where('type', 'outstation');
        return view('user.dashboard', compact('services', 'economy', 'extra_seat', 'luxury', 'outstation'));
       
    }

    /**
     * Show the application profile.
     *
     * @return Response
     */
    public function profile()
    {

        return view('user.account.profile');
    }

    /**
     * Show the application profile.
     *
     * @return Response
     */
    public function edit_profile()
    {
        return view('user.account.edit_profile');
    }

    /**
     * Update profile.
     *
     * @return Response
     */
    public function update_profile(Request $request)
    {
        return $this->UserAPI->update_profile($request);
    }

    /**
     * Show the application change password.
     *
     * @return Response
     */
    public function change_password()
    {
        return view('user.account.change_password');
    }

    /**
     * Change Password.
     *
     * @return Response
     */
    public function update_password(Request $request)
    {
        return $this->UserAPI->change_password($request);
    }

    /**
     * Trips.
     *
     * @return Response
     */
    public function trips()
    {
        $trips = $this->UserAPI->trips();
        // dd($trips);
        return view('user.ride.trips', compact('trips'));
    }

    /**
     * cards.
     *
     * @return Response
     */
    public function cards()
    {
        $cards = (new Resource\CardResource)->index();
        return view('user.account.cards', compact('cards'));
    }

     /**
     * Card.
     *
     * @return Response
     */
    public function card_default($card_id)
    {
        $user_id = request()->user()->id;

        $card = Card::where('user_id', $user_id)->update([
            'is_default' => 0
        ]);

        $card = Card::where('id', $card_id)->update([
            'is_default' => 1
        ]);

        return redirect()->back();
    }

     /**
     * Card.
     *
     * @return Response
     */
    public function card_delete($card_id)
    {
        $card = Card::destroy('id', $card_id);

        return redirect()->back();
    }

     /**
     * Card.
     *
     * @return Response
     */
    public function card_add()
    {
        return view('user.account.add-card');
    }

     /**
     * Card.
     *
     * @return Response
     */
    public function card_store(Request $request)
    {
        try {
            Stripe::setApiKey(Setting::get('stripe_secret_key'));
            $token = Token::create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvc,
                ],
            ]);
    
            return redirect()->back()->with('flash_success', translateKeyword('Card added successfully!'));
    
        } catch(Exception $e) {
            return redirect()->back()->with('flash_error', translateKeyword('Please enable raw data from stripe to add card!'));
        }
       
    }

    public function documents()
    {
        $UserDocuments = Document::user()->get();
        $user = request()->user();

        return view('user.account.documents', compact("UserDocuments", "user"));
    }

    public function update_document(Request $request, $id)
    {
        $this->validate($request, [
            'document' => 'mimes:jpg,jpeg,png,pdf'
        ]); 

        $Document = UserDocument::where('user_id', $request->user()->id)
                        ->where('document_id', $id)
                        ->first();
        $file = $request->document->store('user/documents');
        $file = asset('storage/' . $file);
        if ($Document) {
            if ($request->expires_at)
                $Document->expiry_date = $request->expires_at;

            $Document->url = $file;
            $Document->status =  'ASSESSING';

            $Document->save();
        } else 
            UserDocument::create([
                'url' => $file,
                'user_id' => $request->user()->id,
                'document_id' => $id,
                'status' => 'ASSESSING',
                'expiry_date' => $request->expires_at
            ]);

        User::where('id', $request->user()->id)
            ->update([
                'status' => 'doc_required'
            ]);
        return redirect()->route('user.documents');
    }

    /**
     * Payment.
     *
     * @return Response
     */
    public function payment()
    {
        $cards = (new Resource\CardResource)->index();
        return view('user.account.payment', compact('cards'));
    }


    /**
     * Wallet.
     *
     * @return Response
     */
    public function wallet(Request $request)
    {
        $cards = (new Resource\CardResource)->index();
        return view('user.account.wallet', compact('cards'));
    }

    /**
     * Promotion.
     *
     * @return Response
     */
    public function promotions_index(Request $request)
    {
        $promocodes = $this->UserAPI->promocodes();
        return view('user.account.promotions', compact('promocodes'));
    }

    /**
     * Add promocode.
     *
     * @return Response
     */
    public function promotions_store(Request $request)
    {
        return $this->UserAPI->add_promocode($request);
    }

    /**
     * Upcoming Trips.
     *
     * @return Response
     */
    public function upcoming_trips()
    {
        $trips = $this->UserAPI->upcoming_trips();
        return view('user.ride.upcoming', compact('trips'));
    }

    /**
     * Map of all Users and Drivers.
     *
     * @return Response
     */

    public function map_ajax()

    {

        try {

            $providers = Provider::where('latitude', '!=', 0)
                ->where('longitude', '!=', 0)
                ->with(['service' => function ($q) {
                    $q->where('status', '!=', 'offline');
                }])
                ->get();

            $Users = User::where('latitude', '!=', 0)
                ->where('longitude', '!=', 0)
                ->get();

            for ($i = 0; $i < sizeof($Users); $i) {

                $Users[$i]->status = 'user';

            }

            $All = $Users->merge($providers);

            return $All;

        } catch (Exception $e) {

            return [];

        }

    }

    public function contactEnquiry(Request $request){
        try {
            $request = $request->except(['_token', 'submit']);
            $site_title = getSettings('site_title');
            $contact_email = getSettings('contact_email');

            if (getSettings('smtp_mail') == 1 && getSettings('contact_email') == 1) {
                Mail::send('mails.contact', $request, function ($message) use ($site_title, $contact_email) {
                    $message->to($contact_email, $site_title)->subject('Contact Enquiry');
                    $message->from($contact_email, $site_title);
                });
            }

            ContactEnquiry::create($request);
            
            return back()->with('flash_success', 'Your enquiry has been submitted successfully!');

        } catch (Exception $e) {
            return back()->with('flash_error', 'Something went wrong, please try again later!');
        }
    }

    public function bookingRequest(Request $request){
        try {
            $request = $request->except(['_token', 'submit']);
            $site_title = getSettings('site_title');
            $contact_email = getSettings('contact_email');

            if (getSettings('smtp_mail') == 1 && getSettings('booking_email') == 1) {
                Mail::send('mails.booking', $request, function ($message) use ($site_title, $contact_email) {
                    $message->to($contact_email, $site_title)->subject('Booking Request');
                    $message->from($contact_email, $site_title);
                });
            }

            BookingRequest::create($request);
            
            return response()->json(['error' => false, 'message' => true, 'data' => $request]);
        } catch (Exception $e) {
            return response()->json([ 'error' => true, 'message' => $e->getMessage()]);
        }
    }
}
