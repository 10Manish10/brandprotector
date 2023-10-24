<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCronsRequest;
use App\Http\Requests\UpdateCronsRequest;
use App\Http\Requests\MassDestroyCronRequest;
use Illuminate\Http\Request;
use App\Models\Cron;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class CronController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        abort_if(Gate::denies('cron_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $crons = Cron::all();
        return view('admin.crons.index', compact('crons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        abort_if(Gate::denies('cron_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.crons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCronsRequest $request) {
        $data = $request->all();
        $data['created_by'] = auth()->user()->email;
        Cron::create($data);
        return redirect()->route('admin.crons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cron $cron) {
        abort_if(Gate::denies('cron_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.crons.show', compact('cron'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cron $cron) {
        abort_if(Gate::denies('cron_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.crons.edit', compact('cron'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCronsRequest $request, Cron $cron) {
        $data = $request->all();
        $data['created_by'] = auth()->user()->email;
        $cron->update($data);
        return redirect()->route('admin.crons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cron $cron) {
        abort_if(Gate::denies('cron_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $cron->delete();
        return back();
    }

    public function massDestroy(MassDestroyCronRequest $request) {
        $crons = Cron::find(request('ids'));
        foreach ($crons as $cron) {
            $cron->delete();
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
