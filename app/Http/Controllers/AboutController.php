<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index()
    {
        $about = About::findOrFail(1);
        return view('about.index', compact('about'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param About $about
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function edit(About $about)
    {
        return view('about.edit', compact('about'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param About $about
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, About $about)
    {
        $request->validate([
            'about_text' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png|max:3072'
        ]);


        $data = $request->except('_token', '_method');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_path = public_path($about->image);
            if (file_exists($file_path) && !empty($about->image)) {
                unlink($file_path);
            }
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/about/', $name);
            $image_path = "storage/about/" . $name;
            $data['image'] = $image_path;
        }
        $about->update($data);
        return redirect()->back()->with('success', ' About information updated');
    }


}
