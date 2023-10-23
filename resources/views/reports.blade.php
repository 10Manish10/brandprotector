@extends('layouts.admin')
@section('content')

<style>
    #mainTable td.select-checkbox::before {
        display: none !important;
    }
</style>

<div class="card">
    <div class="card-header">
        Reports
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Select Client</label>
                            <select id="clientsSelect" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="" selected disabled>Select Client</option>
                                @foreach ($data['clients'] as $client)
                                <?php
                                    $k = strip_tags($client->keywords);
                                    $k = htmlspecialchars($k, ENT_QUOTES, 'UTF-8');
                                ?>
                                <option data-keyword="{{ $k }}" value="{{ $client->id }}" data-select2-id="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Select Channel</label>
                            <select id="channelsSelect" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="" selected disabled>Select Channel</option>
                                @foreach ($data['channels'] as $channel)
                                <option value="{{ $channel->id }}" data-cname="{{ $channel->channel_name }}" data-select2-id="{{ $channel->id }}">{{ $channel->channel_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Select Keyword</label>
                            <select id="keywordsSelect" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="" selected disabled>Select Keyword</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row">
                    <div class="col-4">
                        <label>&nbsp;</label>
                        <button style="display:block;width:100%;" type="button" id="view" class="button btn btn-primary">View Data</button>
                    </div>
                    <div class="col-4">
                        <label>&nbsp;</label>
                        <button style="display:block;width:100%;" type="button" id="refresh" class="button btn btn-danger">Refresh Data</button>
                    </div>
                    <div class="col-4"></div>
                </div>
            </div>
        </div>
        <hr>
        <table class="table table-bordered table-striped table-hover datatable datatable-Reports" id="mainTable">
            <thead>
                <tr>
                    <th>Dataset</th>
                    <th>Severity</th>
                    <th>Keyword</th>
                    <th>URL</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Seller</th>
                    <th>Brand</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    $.extend(true, $.fn.dataTable.defaults, {
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 10,
    });
    let table = $('.datatable-Reports:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
    $("#clientsSelect").change(function () {
        var selectedOption = $(this).find("option:selected")
        let keywords = selectedOption.data("keyword")
        $("#keywordsSelect").empty()
        $("#keywordsSelect").append($("<option>", {
            value: "",
            text: "Select Keyword",
            selected: "selected",
            disabled: "disabled"
        }))
        keywords.split(",").forEach(kw => {
            $("#keywordsSelect").append($("<option>", {
                value: kw.trim(),
                text: kw.trim()
            }))
        })

    })
    $(document).on("click", "#view", function() {
        let client = $("#clientsSelect option:selected").val()
        let channel = $("#channelsSelect option:selected").val()
        let cname = $("#channelsSelect option:selected").data("cname")
        let keyword = $("#keywordsSelect option:selected").val()
        if (!(client && channel && keyword && cname)) {
            return false
        }
        if (client == "" && channel == "" && keyword == "" && cname == "") {
            return false
        }
        let dt = $("#mainTable").DataTable()
        $.ajax({
			method: "GET",
			url: `/reports/${client}/${channel}/${cname}/${keyword}`,
			success: (x) => {
                dt.clear().draw()
                if (x.length > 0) {
                    x.forEach(e => {
                        dt.row.add([
                            e.created_at,
                            e.dataset,
                            e.severity,
                            e.keyword,
                            e.url,
                            e.title,
                            e.price,
                            e.image,
                            e.seller,
                            e.brand
                        ]).draw(false)
                    })
                }
			},
			error: (e) => {
				console.error(e)
			}
		})
    })
});
</script>
@endsection