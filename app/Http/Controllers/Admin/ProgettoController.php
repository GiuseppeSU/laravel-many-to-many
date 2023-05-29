<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgettoRequest;
use App\Http\Requests\UpdateProgettoRequest;
use App\Models\Progetto;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProgettoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $progetti = Progetto::all();
        return view('admin.progetti.index', compact('progetti'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.progetti.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgettoRequest $request)
    {




        $validated_data = $request->validated();
        $validated_data['slug'] = Progetto::generateSlug($request->title);
        $checkProgetto = Progetto::where('slug', $validated_data['slug'])->first();
        if ($checkProgetto) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare lo slug per questo post, cambia il titolo']);
        }


        if ($request->hasFile('cover_image')) {
            $path = Storage::put('cover', $request->cover_image);
            $validated_data['cover_image'] = $path;

        }
        $newProgetto = Progetto::create($validated_data);
        if ($request->has('technologies')) {
            $newProgetto->technologies()->attach($request->technologies);

        }


        return redirect()->route('admin.progetti.show', ['progetto' => $newProgetto->slug])->with('status', 'Post creato con successo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Progetto  $progetto
     * @return \Illuminate\Http\Response
     */
    public function show(Progetto $progetto)
    {
        return view('admin.progetti.show', compact('progetto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Progetto  $progetto
     * @return \Illuminate\Http\Response
     */
    public function edit(Progetto $progetto)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.progetti.edit', compact('progetto', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Progetto  $progetto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgettoRequest $request, Progetto $progetto)
    {
        $validated_data = $request->validated();
        $validated_data['slug'] = Progetto::generateSlug($request->title);
        $checkProgetto = Progetto::where('slug', $validated_data['slug'])->where('id', '<>', $progetto->id)->first();
        if ($checkProgetto) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare lo slug']);
        }

        if ($request->hasFile('cover_image')) {

            if ($progetto->cover_image) {
                Storage::delete($progetto->cover_image);
            }

            $path = Storage::put('cover', $request->cover_image);
            $validated_data['cover_image'] = $path;

        }

        $progetto->technologies()->sync($request->technologies);

        $progetto->update($validated_data);
        return redirect()->route('admin.progetti.show', ['progetto' => $progetto->slug])->with('status', 'Post modificato con successo!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Progetto  $progetto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Progetto $progetto)
    {

        if ($progetto->cover_image) {
            Storage::delete($progetto->cover_image);
        }
        $progetto->delete();
        return redirect()->route('admin.progetti.index');
    }


    public function deleteImage($slug)
    {

        $progetto = Progetto::where('slug', $slug)->firstOrFail();

        if ($progetto->cover_image) {
            Storage::delete($progetto->cover_image);
            $progetto->cover_image = null;
            $progetto->save();
        }

        return redirect()->route('admin.progetti.edit', $progetto->slug);

    }
}