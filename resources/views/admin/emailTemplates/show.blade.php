@extends('layouts.admin')
@section('content')

<style>
    .emailTemplate > .card {
        margin: 10px;
    }
    .emailTemplate input[type='text'] {
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-bottom: 1px solid #c9c9c966;
        width: 100%;
    }
    .emailTemplate input[type='text']:hover, .emailTemplate input[type='text']:focus, .emailTemplate input[type='text']:focus-visible {
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-bottom: 2px solid #c9c9c966;
        outline: none;
    }
    .fg {
        display: flex;
        margin-bottom: 10px;
    }
    .fg span {
        font-weight: 500;
        min-width: 60px;
        margin-right: 8px;
    }
    .emailBody {
        margin-top: 10px;
        max-height: 40vh;
        overflow-y: scroll;
        background-color: #fafafa;
        margin: 5px -5px;
        padding: 5px 10px;
        border-radius: 5px;
    }
    .bodyinput {
        max-width: 100px;
        margin-left: 5px;
        margin-right: 5px;
        background-color: #f2f2f2;
        text-align: center;
    }
</style>

<div class="card">
    <div class="card-header">
        <div style="display: flex;align-items: center;">
            <div class="form-group" style="margin-right: 10px;">
                <a class="btn btn-default" href="{{ route('admin.email-templates.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <p>Email Template</p>
        </div>
    </div>
    <div class="card-body">

        <div class="emailTemplate" style="background: #fff !important;color:#000 !important;padding:10px;">
            <div class="card" style="background: #fff !important;color:#000 !important;box-shadow: 0 0 25px #8f83837a;">
                <div class="card-header" style="background: #f2f2f2 !important;color:#041e49 !important;">
                    <span><b>New Message</b></span>
                </div>

                <?php
                    if (preg_match('/{{(.*?)}}/', $emailTemplate->from_email)) {
                        $from = "";
                    } else {
                        $from = $emailTemplate->from_email;
                    }
                    if (preg_match('/{{(.*?)}}/', $emailTemplate->to_email)) {
                        $to = "";
                    } else {
                        $to = $emailTemplate->from_email;
                    }
                    $body = preg_replace('/\{\{([^}]+)\}\}/', '<input type="text" class="bodyinput" name="$1" placeholder="$1" />', $emailTemplate->email_body);
                ?>
                <div class="card-body" style="background: #fff !important;color:#000 !important;">
                    <div class="fg">
                        <span>From: </span>
                        <input type="text" value="{{$from}}" placeholder="Sender" @if ($from != "") disabled="disabled" @endif>
                    </div>
                    <div class="fg">
                        <span>To: </span>
                        <input type="text" value="{{$to}}" placeholder="Recipient" @if ($to != "") disabled="disabled" @endif>
                    </div>
                    <div class="fg">
                        <span>Subject: </span>
                        <input type="text" value="{{$emailTemplate->subject}}" placeholder="Subject">
                    </div>
                    <div class="emailBody">
                        {!! $body !!}
                    </div>
                </div>
                <div class="card-footer" style="background: #fff !important;color:#000 !important;border-top: 1px solid #f2f2f2;">
                    <button class="button btn btn-info">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection