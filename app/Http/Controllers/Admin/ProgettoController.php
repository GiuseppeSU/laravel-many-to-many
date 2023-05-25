<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgettoRequest;
use App\Http\Requests\UpdateProgettoRequest;
use App\Models\Progetto;
use App\Models\Type;
use Illuminate\Http\Request;


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
        return view('admin.progetti.create', compact('types'));
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


        $newProgetto = Progetto::create($validated_data);

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
        return view('admin.progetti.edit', compact('progetto', 'types'));
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
        $progetto->delete();
        return redirect()->route('admin.progetti.index');
    }
}