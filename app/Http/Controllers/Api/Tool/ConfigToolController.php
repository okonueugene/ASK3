<?php

namespace App\Http\Controllers\Api\Tool;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Tag;
use Illuminate\Http\Request;

class ConfigToolController extends Controller
{
    public function getSites()
    {
        $sites = Site::orderBy('id', 'desc')->where('company_id', '=', auth()->user()->company_id)->get();
        return response()->json([
            'success' => true,
            'data' => $sites,
        ]);
    }

    public function allTags()
    {

        $tags = Tag::orderBy('created_at', 'DESC')->where('company_id', '=', auth()->user()->company_id)->get();

        return response()->json([
            'success' => true,
            'data' => $tags,
        ]);
    }

    public function createTag(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'code' => 'required',
            'type' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'site_id' => 'required',
        ]);

        //check if tag exists
        $tag = Tag::where('code', $request->code)->first();
        if ($tag) {
            return response()->json([
                'success' => false,
                'message' => 'Tag already exists',
            ]);
        }

        //create tag
        $tag = Tag::create([
            'company_id' => auth()->user()->company_id,
            'name' => $request->name,
            'location' => $request->location,
            'code' => $request->code,
            'type' => $request->type,
            'lat' => $request->lat,
            'long' => $request->long,
            'site_id' => $request->site_id,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->event('created')
            ->performedOn($tag)
            ->withProperties(['tag' => $tag])
            ->log('Tag created and assigned to site ' . $tag->site->name);

        if ($tag) {
            return response()->json([
                'success' => true,
                'message' => 'Tag created successfully',
                'data' => $tag,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tag not created',
                'error' => $errors->all(),
            ]);
        }

    }

    public function updateTag(Request $request)
    {
        //find tag
        $tag = Tag::findOrFail($request->tag_id);

        if ($tag) {
            //update tag
            $tag->update([
                $request->all(),
            ]);

            activity()
                ->causedBy(auth()->user())
                ->event('updated')
                ->performedOn($tag)
                ->withProperties(['tag' => $tag])
                ->useLog('Tag')
                ->log('Tag updated');

            return response()->json([
                'success' => true,
                'message' => 'Tag updated successfully',
                'data' => $tag,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found',
            ]);
        }
    }

    public function deleteTag(Request $request)
    {
        //find tag
        $tag = Tag::findOrFail($request->tag_id);

        if ($tag) {
            //delete tag
            $tag->delete();

            activity()
                ->causedBy(auth()->user())
                ->event('deleted')
                ->performedOn($tag)
                ->withProperties(['tag' => $tag])
                ->useLog('Tag')
                ->log('Tag deleted');

            return response()->json([
                'success' => true,
                'message' => 'Tag deleted successfully',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tag not found',
            ]);
        }
    }

    public function getSiteTags(Request $request)
    {
        //find site
        $site = Site::findOrFail($request->site_id);

        if ($site) {
            //get site tags
            $tags = Tag::where('site_id', $request->site_id)->get();

            return response()->json([
                'success' => true,
                'message' => 'Site tags',
                'data' => $tags,
            ]);

            activity()
                ->causedBy(auth()->user())
                ->event('viewed')
                ->performedOn($site)
                ->withProperties(['site' => $site])
                ->useLog('Site')
                ->log('Viewed site tags');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Site not found',
            ]);
        }
    }

}
