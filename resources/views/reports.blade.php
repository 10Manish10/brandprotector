@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Reports
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover datatable datatable-Reports">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>client id</th>
                    <th>channel name</th>
                    <th>severity</th>
                    <th>keyword</th>
                </tr>
                </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->client_id }}</td>
                        <td>{{ $item->channel_name }}</td>
                        <td>{{ $item->severity }}</td>
                        <td>{{ $item->keyword }}</td>
                    </tr>
                @endforeach
            </tbody>
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

    // let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    // let dtOverrideGlobals = {
    //     buttons: dtButtons,
    //     processing: true,
    //     serverSide: true,
    //     retrieve: true,
    //     aaSorting: [],
    //     ajax: "{{ route('reports') }}",
    //     orderCellsTop: true,
    //     order: [[ 2, 'asc' ]],
    //     pageLength: 10,
    // };
    // let table = $('.datatable-Reports').DataTable(dtOverrideGlobals);
    // $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
    //     $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    // });
  
    // let visibleColumnsIndexes = null;
    // $('.datatable thead').on('input', '.search', function () {
    //     let strict = $(this).attr('strict') || false
    //     let value = strict && this.value ? "^" + this.value + "$" : this.value
    //     let index = $(this).parent().index()
    //     if (visibleColumnsIndexes !== null) {
    //         index = visibleColumnsIndexes[index]
    //     }
    //     table.column(index).search(value, strict).draw()
    // });
    // table.on('column-visibility.dt', function(e, settings, column, state) {
    //     visibleColumnsIndexes = []
    //     table.columns(":visible").every(function(colIdx) {
    //         visibleColumnsIndexes.push(colIdx);
    //     });
    // })
});
</script>
@endsection