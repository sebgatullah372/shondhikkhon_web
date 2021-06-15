<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use Illuminate\Http\Request;

class PricingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     *
     */
    public function index()
    {
        $pricing_plans = PricingPlan::all();
        return view('pricing_plan.index', compact('pricing_plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|max:70',
            'price' => 'required',
            'discount' => 'required',
            'final_price' => 'required',
        ]);
        $data = $request->except('_token', 'files');
        PricingPlan::create($data);
        return redirect()->back()->with('success', ' New pricing plan created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PricingPlan  $pricingPlan
     * @return \Illuminate\Http\Response
     */
    public function show(PricingPlan $pricingPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PricingPlan $pricingPlan
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function edit(PricingPlan $pricingPlan)
    {
        return view('pricing_plan.edit', compact('pricingPlan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PricingPlan $pricingPlan
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, PricingPlan $pricingPlan)
    {
        $request->validate([
            'name' => 'required|max:70',
            'price' => 'required',
            'discount' => 'required',
            'final_price' => 'required',
        ]);
        $data = $request->except('_token', '_method');
        $pricingPlan->update($data);
        return redirect()->back()->with('success', ' Pricing plan updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PricingPlan  $pricingPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PricingPlan $pricingPlan)
    {
        //
    }
}
