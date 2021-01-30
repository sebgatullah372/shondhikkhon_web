<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index()
    {
        $services = Service::all();
        return view('service.index', compact('services'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:190',
            'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=1500'
        ],
            ['cover_photo.dimensions' => 'Please upload a landscape image with height not more than 1500px']);



        $data = $request->except('_token');

        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/services/cover_photos', $name);
            $image_path = "storage/services/cover_photos/" . $name;
            $data['cover_photo'] = $image_path;
        }
        Service::create($data);
        return redirect()->back()->with('success', ' New service created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Service $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function edit(Service $service)
    {
        return view('service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Service $service
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|max:190',
            'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:3072|dimensions:max_height=1500'
        ],
            ['cover_photo.dimensions' => 'Please upload a landscape image with height not more than 1500px']);



        $data = $request->except('_token', '_method');

        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $file_path = public_path($service->cover_photo);
            if (file_exists($file_path) && !empty($service->cover_photo)) {
                unlink($file_path);
            }

            $name = time() . '.' . $image->getClientOriginalExtension(); //getting the extension

            $image->storePubliclyAs('public/services/cover_photos', $name);
            $image_path = "storage/services/cover_photos/" . $name;
            $data['cover_photo'] = $image_path;
        }

        $service->update($data);
        return redirect()->back()->with('success', ' Service updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}
