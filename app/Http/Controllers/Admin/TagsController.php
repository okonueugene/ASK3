<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index()
    {
        return view('admin.tags');
    }

    public function addTag(Request $request)
    {
        $tag = Tag::create($request->all());
        activity()
            ->performedOn($tag)
            ->event('created')
            ->causedBy($request->user())
            ->withProperties(['attributes' => $tag->toArray()])
            ->log('created');
        return redirect()->route('admin.tags.show', $tag->id);
    }


    public function updateTag(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($request->all());
        activity()
            ->performedOn($tag)
            ->event('updated')
            ->causedBy($request->user())
            ->withProperties(['attributes' => $tag->toArray()])
            ->log('updated');
        return redirect()->route('admin.tags.show', $tag->id);
    }

    public function deleteTag($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        activity()
            ->performedOn($tag)
            ->event('deleted')
            ->causedBy($request->user())
            ->withProperties(['attributes' => $tag->toArray()])
            ->log('deleted');
        return redirect()->route('admin.tags.index');
    }

    
}
