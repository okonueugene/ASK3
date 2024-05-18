<?php

namespace App\Http\Controllers\Admin\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Tag;
use Illuminate\Http\Request;

class SiteTagsController extends Controller
{

    public $site;
    private const CODE_LENGTH = 11;

    public function index($id)
    {
        $title = 'Site Tags';
        $this->site = Site::findOrFail($id);
        $tags = $this->site->tags;
        $site = $this->site;
        return view('admin.sites.tags', compact('title', 'site', 'tags'));
    }

    //add single tag
    public function addSingleTag(Request $request, $id)
    {
        //validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'code' => 'required|string|max:255',
        ]);

        //check if tag exists
        $tag = Tag::where('code', $request->code)->first();

        //if tag exists, return error
        if ($tag) {
            return redirect()->back()->with('error', 'Tag already exists');
        }

        //create tag
        $tag = Tag::create([
            'company_id' => auth()->user()->company_id,
            'site_id' => $id,
            'name' => $request->name,
            'type' => 'qr',
            'location' => $request->location,
            'code' => $request->code,
            'lat' => 0.0,
            'long' => 0.0,
        ]);
        //log the tag creation
        activity()
            ->performedOn($tag)
            ->causedBy(auth()->user())
            ->log('Tag created');
        //return success message
        return redirect()->back()->with('success', 'Tag added successfully');
    }

    private function generateQrCodes()
    {
        //generate a random string
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        //generate a random string
        do {
            $randomString = substr(str_shuffle($characters), 0, self::CODE_LENGTH);
            $tag = Tag::where('code', $randomString)->first();

        } while ($tag);

        //return the random string
        return $randomString;
    }

    //add multiple tags
    public function addMultipleTags(Request $request, $id)
    {
        // Validate the number of tags to be added
        $request->validate([
            'number' => 'required|integer|min:1',
        ]);
        //get the number of tags to be added
        $numberOfTags = $request->number;

        //loop through the number of tags
        for ($i = 0; $i < $numberOfTags; $i++) {
            //generate a random string
            $randomString = $this->generateQrCodes();

            //create the tag
            $tag = Tag::create([
                'company_id' => auth()->user()->company_id,
                'site_id' => $id,
                'type' => 'qr',
                'code' => $randomString,
                'lat' => 0.0,
                'long' => 0.0,
            ]);
        }

        //log the tag creation
        activity()
            ->performedOn($tag)
            ->causedBy(auth()->user())
            ->log('Tags created');

        //return success message
        return redirect()->back()->with('success', 'Tags added successfully');
    }

    //delete tag
    public function deleteTag($id)
    {
        //find the tag
        $tag = Tag::findOrFail($id);

        //delete the tag
        $tag->delete();

        //log the tag deletion
        activity()
            ->performedOn($tag)
            ->causedBy(auth()->user())
            ->log('Tag deleted');

        //return success message
        return response()->json([
            'success' => true,
            'message' => 'Tag deleted successfully',
        ]);
    }
}
