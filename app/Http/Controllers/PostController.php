<?php

namespace App\Http\Controllers;

use App\PostCollection;
use Validator;
use Illuminate\Http\Request;
use App\Post;
use App\Collection;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')->with('posts', Post::where('template_id', 1)->orderBy('date', 'desc')->get());
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
        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'date'        => 'required',
            'template_id' => 'required'
        ]);
        if (!$validator->fails()) {
            try {
                DB::beginTransaction();
                $article    = Post::create($request->all());
                $collection = Collection::firstOrCreate([
                    'name' => 'medias',
                ], [
                    'name' => 'medias',
                ]);

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
                DB::commit();
                return redirect()->route('posts.edit', ["id" => $article->id])
                    ->with('status', 'Post créé');
            } catch (\Exception $e) {
                DB::rollback();
                $validator->errors()->add('general', 'Une erreur est survenue');
                return redirect()->route('posts.create')
                    ->withErrors($validator)
                    ->withInput();
            }
        } else {
            return redirect()->route('posts.create')
                ->withErrors($validator)
                ->withInput();
        }


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
        $post = Post::findOrFail($id);
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
        $request->validate([
            'title'          => 'required',
            'date'           => 'required',
            'template_id'    => 'required',
        ]);
        $article = Post::find($id);
        DB::transaction(function () use ($request, $article) {
            $article->title       = request()->input('title');
            $article->description = request()->input('description');
            $article->template_id = request()->input('template_id');
            $article->save();
            $collection = $article->collections->first();
            if (!$collection) {
                $collection = Collection::firstOrCreate([
                    'name' => 'medias',
                ], [
                    'name' => 'medias',
                ]);
            }
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

            if (is_array($request->medias)) {
                foreach (request()->medias as $media) {
                    $model              = Post::find($media['id']);
                    if (isset($media['destroy']) && (int) $media['destroy']) {
                        $postCollection = PostCollection::where('owner_id', $article->id)
                            ->where('post_id', $media['id'])
                            ->where('collection_id', $collection->id)
                            ->first();
                        $postCollection->deleted_at = \Carbon\Carbon::now();
                        $postCollection->save();
                        $model->delete();
                    } else {
                        $model->title       = $media['title'];
                        $model->description = $media['description'];
                        $model->save();
                    }
                }
            }
        });
        return redirect()->route('posts.index')
            ->with('status', 'Post mis à jour');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route("posts.index");
    }
}
