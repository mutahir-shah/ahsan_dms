<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use DB;
use App\FavouriteLocation;
use App\UserRequests;

class FavouriteLocationResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $HomeLocation = FavouriteLocation::where(['type' => 'home', 'user_id' => Auth::user()->id])->get();
        $WorkLocation = FavouriteLocation::where(['type' => 'work', 'user_id' => Auth::user()->id])->get();
        $OthersLocation = FavouriteLocation::where(['type' => 'others', 'user_id' => Auth::user()->id])->get();

        $SourceAddressRecent = UserRequests::select(['id', 'user_id', 's_address as address', 's_latitude as latitude', 's_longitude as longitude', DB::Raw('"recent" as type')])->where('user_id', Auth::user()->id)->distinct('s_address')->orderBy('id', 'desc');
        $DistinationAddressRecent = UserRequests::select(['id', 'user_id', 'd_address as address', 'd_latitude as latitude', 'd_longitude as longitude', DB::Raw('"recent" as type')])->where('user_id', Auth::user()->id)->distinct('d_address')->orderBy('id', 'desc');

        $RecentLocation = $SourceAddressRecent->union($DistinationAddressRecent)->orderBy('id', 'desc')->skip(0)->take(10)->get();

        foreach ($RecentLocation as $key => $value) {
            $RecentLocation[$key]->id = $value->id;
            $RecentLocation[$key]->user_id = (float)$value->user_id;
            $RecentLocation[$key]->address = $value->address;
            $RecentLocation[$key]->latitude = (float)$value->latitude;
            $RecentLocation[$key]->longitude = (float)$value->longitude;
            $RecentLocation[$key]->type = $value->type;
        }

        $SearchLocation = ["home" => $HomeLocation, "work" => $WorkLocation, "others" => $OthersLocation,
            "recent" => $RecentLocation];

        return $SearchLocation;

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
    public function store(Request $request)
    {
        $this->validate($request, [
            'address' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'required|in:home,work,recent,others'
        ]);

        try {

            $Location['user_id'] = Auth::user()->id;
            $Location['address'] = $request->address;
            $Location['latitude'] = $request->latitude;
            $Location['longitude'] = $request->longitude;
            $Location['type'] = $request->type;

            $IsExists = FavouriteLocation::where([['user_id', $Location['user_id']], ['type', $Location['type']]])->count();

            if ($IsExists == 0) {
                FavouriteLocation::create($Location);
                if ($request->ajax()) {
                    return response()->json(['message' => 'Favourite Location Saved Successfully'], 200);
                } else {
                    return back()->with('flash_success', 'Favourite Location Saved Successfully');
                }
            } else {
                FavouriteLocation::where([['user_id', $Location['user_id']], ['type', $Location['type']]])->update($Location);
                if ($request->ajax()) {
                    return response()->json(['error' => 'Favourite Location Updated'], 200);
                } else {
                    return back()->with('flash_error', 'Favourite Location Updated');
                }
            }
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Favourite Location Not Found'], 404);
            } else {
                return back()->with('flash_error', 'Favourite Location Not Found');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $Favourite = FavouriteLocation::findOrFail($id);
            if ($request->ajax()) {
                return $Favourite;
            } else {
                return back()->with('flash_error', 'Favourite Location Not Found');
            }
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Favourite Location Not Found'], 500);
            } else {
                return back()->with('flash_error', 'Favourite Location Not Found');
            }

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $Favourite = FavouriteLocation::findOrFail($id);

            if ($request->ajax()) {
                return $Favourite;
            } else {
                return back()->with('flash_error', 'Favourite Location Not Found');
            }
        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Favourite Location Not Found'], 500);
            } else {
                return back()->with('flash_error', 'Favourite Location Not Found');
            }

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'address' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'required|in:home,work,recent,others'
        ]);

        try {
            $UpdateLocation = FavouriteLocation::findOrFail($id);

            $Location['user_id'] = Auth::user()->id;
            $Location['address'] = $request->address;
            $Location['latitude'] = $request->latitude;
            $Location['longitude'] = $request->longitude;
            $Location['type'] = $request->type;
            $IsExists = FavouriteLocation::where($Location)->count();

            if ($IsExists == 0) {

                $UpdateLocation->user_id = Auth::user()->id;
                $UpdateLocation->address = $request->address;
                $UpdateLocation->latitude = $request->latitude;
                $UpdateLocation->longitude = $request->longitude;
                $UpdateLocation->type = $request->type;
                $UpdateLocation->save();

                if ($request->ajax()) {
                    return response()->json(['message' => 'Favourite Location Updated Successfully'], 200);
                } else {
                    return back()->with('flash_success', 'Favourite Location Updated Successfully');
                }

            } else {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Favourite Location Already Exists'], 400);
                } else {
                    return back()->with('flash_error', 'Favourite Location Already Exists');
                }

            }

        } catch (ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Favourite Location Not Found'], 500);
            } else {
                return back()->with('flash_error', 'Favourite Location Not Found');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            FavouriteLocation::find($id)->delete();
            return back()->with('message', 'Favourite location deleted successfully');
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Favourite locatio Not Found');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Favourite location Not Found');
        }
    }
}
