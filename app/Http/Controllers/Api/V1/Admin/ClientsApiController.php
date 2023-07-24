<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\Admin\ClientResource;
use App\Models\Client;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('client_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ClientResource(Client::all());
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->all());

        if ($request->input('logo', false)) {
            $client->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        foreach ($request->input('document_proof', []) as $file) {
            $client->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document_proof');
        }

        return (new ClientResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Client $client)
    {
        abort_if(Gate::denies('client_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ClientResource($client);
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->all());

        if ($request->input('logo', false)) {
            if (! $client->logo || $request->input('logo') !== $client->logo->file_name) {
                if ($client->logo) {
                    $client->logo->delete();
                }
                $client->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($client->logo) {
            $client->logo->delete();
        }

        if (count($client->document_proof) > 0) {
            foreach ($client->document_proof as $media) {
                if (! in_array($media->file_name, $request->input('document_proof', []))) {
                    $media->delete();
                }
            }
        }
        $media = $client->document_proof->pluck('file_name')->toArray();
        foreach ($request->input('document_proof', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $client->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document_proof');
            }
        }

        return (new ClientResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Client $client)
    {
        abort_if(Gate::denies('client_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $client->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
