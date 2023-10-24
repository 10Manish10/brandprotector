@extends('layouts.admin')
@section('content')
@can('cron_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.crons.create') }}">Add Cron Job</a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Cron Jobs List
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-cron">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th style="display:none;">ID</th>
                        <th>Name</th>
                        <th>Command</th>
                        <th>Schedule</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="display:none;"><input class="search form-control" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search form-control" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search form-control" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search form-control" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td><input class="search form-control" type="text" placeholder="{{ trans('global.search') }}"></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($crons as $key => $cron)
                        <tr data-entry-id="{{ $cron->id }}">
                            <td></td>
                            <td style="display:none;">{{ $cron->id ?? '' }}</td>
                            <td>{{ $cron->name ?? '' }}</td>
                            <td>{{ $cron->command ?? '' }}</td>
                            <td>{{ $cron->schedule ?? '' }}</td>
                            <td>{{ $cron->created_by ?? '' }}</td>
                            <td>
                                @can('cron_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.crons.show', $cron->id) }}">{{ trans('global.view') }}</a>
                                @endcan
                                @can('cron_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.crons.edit', $cron->id) }}">{{ trans('global.edit') }}</a>
                                @endcan
                                @can('cron_delete')
                                    <form action="{{ route('admin.crons.destroy', $cron->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('cron_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.crons.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-cron:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection