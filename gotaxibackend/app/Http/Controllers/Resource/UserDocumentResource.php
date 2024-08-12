<?php

namespace App\Http\Controllers\Resource;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SendPushNotification;

use App\User;
use App\UserDocument;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Setting;

class UserDocumentResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, User $user)
    {
        try {
            $userDocsIds = UserDocument::where('user_id', $user->id)->pluck('document_id');
            if (count($userDocsIds)) {
                $UserDocuments = Document::whereNotIn('id', $userDocsIds)->where('type', 'USER')->get();
            } else {
                $UserDocuments = Document::where('type', 'USER')->get();
            }
    
            $UserDocumentsData = UserDocument::where('user_id', $user->id)
                ->with(['document'])
                ->whereHas('document', function (Builder $query) {
                    $query->where('type', 'User');
                })
                ->get();
    
            return view('admin.users.document.index', compact('UserDocuments', 'user', 'UserDocumentsData'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.index');
        }
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
    public function store(Request $request, User $user)
    {
            $this->validate($request, [
                'document_id' => 'integer|required',
                'document' => 'mimes:jpg,jpeg,png,pdf',
            ]);
            

            try {
                $Document = UserDocument::where('user_id', $user->id)
                    ->where('document_id', $request->document_id)
                    ->firstOrFail();
            

                $file = $request->document->store('user/documents');
                $file = asset('storage/' . $file);

                $Document->update([
                    'url' => $file,
                    'status' => 'ASSESSING',
                    'expiry_date' => $request->expiry_date != '' ? $request->expiry_date : null,
                ]);

                return redirect()->route('admin.user_documents.index', $user->id)->with('flash_success', translateKeyword('User document added successfully!'));
               

            } catch (ModelNotFoundException $e) {

                $file = $request->document->store('user/documents');
                $file = asset('storage/' . $file);

                UserDocument::create([
                    'url' => $file,
                    'user_id' => $user->id,
                    'document_id' => $request->document_id,
                    'status' => 'ASSESSING',
                    'expiry_date' => $request->expiry_date != '' ? $request->expiry_date : null,
                ]);


                return redirect()->route('admin.user_documents.index', $user)->with('flash_success', translateKeyword('User document added successfully!'));

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, User $user, $id)
    {
        try {
            $Document = UserDocument::where('user_id', $user->id)
                ->findOrFail($id);

            return view('admin.users.document.edit', compact('Document'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.index');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
  
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, User $user, $id)
    {
        try {
            $Document = UserDocument::with('document')->where('user_id', $user->id)
                ->findOrFail($id);
            $Document->update(['status' => 'ACTIVE']);

            (new SendPushNotification)->DocumentsVerfied($user->id, $Document->document->name);

            $userDocsIds = UserDocument::where('user_id', $user->id)->pluck('document_id');
            $documentsUser = Document::whereNotIn('id', $userDocsIds)->where('type', 'USER')->first();
            if (!$documentsUser) {
                $user->status = 'approved';
                $user->save();
            }

            return redirect()
                ->route('admin.user_documents.index', $user->id)
                ->with('flash_success', translateKeyword('User document has been approved.'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.user_documents.index', $user->id)
                ->with('flash_error', translateKeyword('User not found!'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(User $user, $id)
    {
        try {
            $user->status = 'doc_required';
            $user->save();

            $userDoc = UserDocument::with('document')->where('id', $id)->first();

            (new SendPushNotification)->DocumentsDeleted($user->id, $userDoc->document->name);

            $Document = UserDocument::destroy($id);


            return redirect()
                ->route('admin.user_documents.index', $user->id)
                ->with('flash_success', translateKeyword('User document has been deleted'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('admin.user_documents.index', $user->id)
                ->with('flash_error', translateKeyword('User not found!'));
        }
    }

}
