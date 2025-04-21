<?php

namespace App\Http\Controllers;

use App\Models\HubLink;
use App\Http\Requests\StoreHubLinkRequest;
use App\Http\Requests\UpdateHubLinkRequest;
use Illuminate\Contracts\Pipeline\Hub;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class HubLinkController extends Controller
{
    public function index()
    {
        return view('hub-links.index', [
            'hubLinks' => HubLink::all()->sortBy('order'),
        ]);
    }

    public function create()
    {
        return view('hub-links.create');
    }

    public function store(StoreHubLinkRequest $request)
    {
        $hubLink = new HubLink();
        $hubLink->title = $request->validated()['title'];
        $hubLink->url = $request->validated()['url'];
        if ($request->order == null) {
            $hubLink->order = HubLink::all()->max('order') + 10;
        } else {
            $hubLink->order = $request->validated()['order'];
        }
        $hubLink->description = $request->description;
        $hubLink->save();

        if ($request->hasFile('icon')) {
            $imageName = $hubLink->id . '.' . $request->icon->getClientOriginalExtension();
            $image = $request->file('icon');
            $imageToEdit = Image::read($image->getPathname());
            $imageToEdit->scale(height: 70);
            $imageToEdit->save(public_path('/uploads/hubicons/' . $imageName));

            // $request->icon->move(public_path('/uploads/hubicons'), $imageName);
            $hubLink->icon = $imageName;
            $hubLink->save();
        }
        return redirect()->route('hublinks.index')
            ->with('success', 'Hub link created successfully.');
    }

    public function show(HubLink $hubLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHubLinkRequest $request, HubLink $hublink)
    {
        if ($request->hasFile('icon')) {
            echo "fileExists";
            if ($hublink->icon) {
                Storage::disk('public_uploads')->delete('hubicons/' . $hublink->icon);
            }

            $imageName = $hublink->id . '.' . $request->icon->getClientOriginalExtension();
            $image = $request->file('icon');
            $imageToEdit = Image::read($image->getPathname());
            $imageToEdit->scale(height: 70);
            $imageToEdit->save(public_path('/uploads/hubicons/' . $imageName));
            // $imageName = $hubLink->id . '.' . $request->icon->getClientOriginalExtension();
            // $request->icon->move(public_path('/uploads/hubicons'), $imageName);
            $hublink->icon = $imageName;
        }
        $hublink->title = $request->validated()['title'];
        $hublink->url = $request->validated()['url'];
        if ($request->order == null) {
            $hublink->order = HubLink::all()->max('order') + 10;
        } else {
            $hublink->order = $request->validated()['order'];
        }
        $hublink->description = $request->description;
        $hublink->save();
        return redirect()->route('hublinks.index')
            ->with('success', 'Hub Link updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $hubLink)
    {
        $hubLink = HubLink::find($hubLink);
        Storage::disk('public_uploads')->delete('hubicons/' . $hubLink->icon);
        $hubLink->delete();
        return redirect()->route('hublinks.index')
            ->with('success', 'Hub Link deleted successfully');
    }
}
