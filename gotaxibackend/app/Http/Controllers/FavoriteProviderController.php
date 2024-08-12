<?php

namespace App\Http\Controllers;
use App\FavoriteProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FavoriteProviderController extends Controller
{
    public function index()
    {
        $favorite_providers = FavoriteProvider::with(['provider'])
            ->where('user_id', Auth::user()->id)
            ->get();

        return  [ 'success' => true, 'providers' => $favorite_providers ];
    }

    // public function index(Request $request)
    // {
    //    // Fetch favorite providers along with their associated providers
    //     $favorite_providers = FavoriteProvider::with(['provider'])
    //     ->where('user_id', Auth::user()->id)
    //     ->get();

    //     // Create an instance of UserApiController
    //     $userApiController = new UserApiController();

    //     // Initialize an array to store filtered favorite providers
    //     $filteredFavoriteProviders = [];

    //     // Loop through each favorite provider
    //     foreach ($favorite_providers as $fav) {
    //     // Initialize an array to store the favorite provider details along with its services
    //     $favData = $fav->toArray();
    //     $favData['services'] = [];

    //     // Loop through each service of the favorite provider
    //     foreach ($fav->services as $service) {
    //         // Get the translated service type
    //         $translatedServiceType = $userApiController->getServicesWithMultiLanguageAndByServiceTypeId($service->service_type_id, $request);

    //         // Add the service with the translated service type to the services array
    //         $serviceData = $service->toArray();
    //         $serviceData['service_type'] = $translatedServiceType;
    //         $favData['services'][] = $serviceData;
    //     }

    //     // Add the favorite provider with its services to the filteredFavoriteProviders array
    //     $filteredFavoriteProviders[] = $favData;
    //     }
        
    //     return  [ 'success' => true, 'providers' => $filteredFavoriteProviders ];
    // }

    public function toggleFavorite(Request $request, $provider_id)
    {
        // $this->validate($request, [
        //     'provider_id' => 'required|integer|exists:providers,id',
        //     'user_id' => 'required|integer|exists:users,id',
        // ]);

        try {
                $favorite_providers = FavoriteProvider::where('provider_id', $provider_id)
                ->where('user_id', Auth::user()->id)
                ->first();

                if ($favorite_providers)
                    $favorite_providers->delete();

                else
                    FavoriteProvider::create([
                        'provider_id' => $provider_id,
                        'user_id' => Auth::user()->id,
                    ]);


            return [ 'success' => true, 'provider' => [] ];
        } catch (Exception $e) {

            return response()->json(['error' => trans('api.something_went_wrong'), 'data' => $e->getMessage()], 500);

        }
    }
       

}
