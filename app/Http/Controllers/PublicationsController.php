<?php

namespace App\Http\Controllers;

use App\Models\Publications\Publications;
use App\Http\Requests\StorePublicationsRequest;
use App\Http\Requests\UpdatePublicationsRequest;

class PublicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePublicationsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Publications $publications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publications $publications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePublicationsRequest $request, Publications $publications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publications $publications)
    {
        //
    }
}
