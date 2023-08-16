<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEmailTemplateRequest;
use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Http\Resources\Admin\EmailTemplateResource;
use App\Models\EmailTemplate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailTemplatesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('email_template_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmailTemplateResource(EmailTemplate::with(['clients', 'channels'])->get());
    }

    public function store(StoreEmailTemplateRequest $request)
    {
        $emailTemplate = EmailTemplate::create($request->all());
        $emailTemplate->clients()->sync($request->input('clients', []));
        $emailTemplate->channels()->sync($request->input('channels', []));

        return (new EmailTemplateResource($emailTemplate))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmailTemplate $emailTemplate)
    {
        abort_if(Gate::denies('email_template_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmailTemplateResource($emailTemplate->load(['clients', 'channels']));
    }

    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $emailTemplate)
    {
        $emailTemplate->update($request->all());
        $emailTemplate->clients()->sync($request->input('clients', []));
        $emailTemplate->channels()->sync($request->input('channels', []));

        return (new EmailTemplateResource($emailTemplate))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        abort_if(Gate::denies('email_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emailTemplate->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
