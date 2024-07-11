@extends('layouts.main')
@section('content')
<!-- Container fluid -->
<div class="container-fluid col-lg-12">
    <div class="row card card-rounded shadow-regular my-2 mx-1 py-3 px-1">
        <div class="col-lg-12">
        </div>
        <div class="col-lg-12">
            <a href="#" class="btn btn-sm btn-outline-secondary mt-1 mb-1 bg bg-dark text-light"><i class="fas fa-file-excel"></i>&nbsp;&nbsp;Export Excel</a>
        </div>
        <div class="col-lg-12">
            <table class="table table-striped table-sm border data-table" id="table">
                <thead class="table-dark">
                    <tr>
                        <td>#</td>
                        <td>Date</td>
                        <td>Log Type</td>
                        <td>Done By</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {

        var table = $('.data-table').DataTable({

            buttons: [{
                text: 'My button',
                action: function(e, dt, button, config) {
                    var info = dt.buttons.exportInfo();
                }
            }],
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_audits') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    print: true,
                    className: 'centered-text'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    orderable: true,
                    searchable: true,
                    print: true,
                    className: 'centered-text'
                },
                {
                    data: 'event',
                    name: 'event',
                    orderable: true,
                    searchable: true,
                    print: true,
                    className: 'centered-text'
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                    orderable: false,
                    searchable: true,
                    print: true,
                    className: 'centered-text'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    print: false,
                    className: 'centered-text'
                },

            ]

        });

    });//END DOCUMENT READY FUNCTION
</script>
@endsection
