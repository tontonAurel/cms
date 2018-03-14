<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Collection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $article    = Post::create($request->all());
        $collection = Collection::create([
            'name' => 'medias',
        ]);

        foreach ($request->photos as $file) {
            $post = Post::create([
                'title'       => '',
                'description' => '',
                'template_id' => 2
            ]);
            $article->collections()->attach($collection->id, ['post_id' => $post->id]);
            $post->addMedia($file)->toMediaCollection();
        }
        return redirect()->route('posts.edit', ["id" => $article->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article              = Post::find($id);
        $article->title       = request()->input('title');
        $article->description = request()->input('description');
        $article->save();
        $collection = $article->collections->first();
        if (is_array($request->photos)) {
            foreach ($request->photos as $file) {
                $post = Post::create([
                    'title'       => '',
                    'description' => '',
                    'template_id' => 2
                ]);
                $article->collections()->attach($collection->id, ['post_id' => $post->id]);
                $post->addMedia($file)->toMediaCollection();
            }
        }

        foreach (request()->medias as $id => $media) {
            $model              = Post::find($id);
            $model->title       = $media['title'];
            $model->description = $media['description'];
            $model->save();
        }
        return redirect()->route('posts.edit', ['id' => $article->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
