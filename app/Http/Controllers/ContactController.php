<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     *  Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index()
    {
        $contact = Contact::findOrFail(1);
        return view('contact.index', compact('contact'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Contact $contact
     * @return \Illuminate\Http\RedirectResponse
     *
     *
     */
    public function update(Request $request, Contact $contact)
    {
       // dd($request->all());
        $request->validate([
            'phone1' => 'required',
            'email' => 'required|email',
            'facebook_link' => 'sometimes|url|nullable',
            'twitter_link' => 'sometimes|url|nullable',
            'instagram_link' => 'sometimes|url|nullable',
            'youtube_link' => 'sometimes|url|nullable',

        ]);

        $data = $request->except('_token', '_method');

        $contact->update($data);
        return redirect()->back()->with('success', ' Contact information updated');
    }


}
