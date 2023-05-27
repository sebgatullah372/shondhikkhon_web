<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index()
    {

        $site_settings = SiteSetting::findOrFail(1);
        return view('site_settings.index', compact('site_settings'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param SiteSetting $site_setting
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function edit(SiteSetting $site_setting)
    {
        return view('site_settings.edit', compact('site_setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SiteSetting $site_setting
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, SiteSetting $site_setting)
    {
        $request->validate([
            'tagline' => 'required',
            'logo' => 'image|mimes:jpeg,jpg,png|max:3072'
        ]);


        $data = $request->except('_token', '_method');

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $file_path = public_path($site_setting->logo);
            if (file_exists($file_path) && !empty($site_setting->logo)) {
                unlink($file_path);
            }
            $name = time() . '.' . $logo->getClientOriginalExtension(); //getting the extension

            $logo->storePubliclyAs('public/logo/', $name);
            $logo_path = "storage/logo/" . $name;
            $data['logo'] = $logo_path;
        }
        $site_setting->update($data);
        return redirect()->back()->with('success', ' Settings updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SiteSetting  $siteSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSetting $siteSetting)
    {
        //
    }
}
