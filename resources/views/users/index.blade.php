@extends('layouts.main')
@section('content')
<!-- Container fluid -->
<div class="container-fluid col-lg-12">
    <div class="row card card-rounded shadow-regular my-2 mx-1 py-3 px-1">
        <div class="col-lg-12">
            <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#add_model"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add User</button>
        </div>
        <div class="col-lg-12">
            <table class="table table-striped table-sm border data-table" id="table">
                <thead class="table-dark">
                    <tr>
                        <td>#</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Role</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
</div>
<!-- Add Modal -->
<div class="modal fade" id="add_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route("add-user")}}" method="POST" enctype="multipart/form-data" id="add-user-form">
            @csrf
        <div class="modal-header bg bg-dark">
          <h5 class="modal-title text-light" id="exampleModalLabel">Add User</h5>
          <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name" class="">Full Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="form-group">
            <label for="name" class="">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="form-group">
            <label for="name" class="">Role</label>
            <select name="role" class="form-control" required>
                <option value="" selected disabled>Select role</option>
                <option value="Super Admin">Super Admin</option>
                <option value="Basic Admin">Basic Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Add</button>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Modal -->
<!-- Edit Modal -->
<div class="modal fade" id="edit_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route("update-user")}}" method="POST" enctype="multipart/form-data" id="update-user-form">
            @csrf
        <div class="modal-header bg bg-dark">
          <h5 class="modal-title text-light" id="exampleModalLabel">Edit User</h5>
          <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="user_id" id="user_id">
          <div class="form-group">
            <label for="name" class="">Full Name</label>
            <input type="text" class="form-control" name="name" required id="name">
          </div>
          <div class="form-group">
            <label for="name" class="">Email</label>
            <input type="email" class="form-control" name="email" required id="email">
          </div>
          <div class="form-group">
            <label for="name" class="">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="" selected disabled>Select role</option>
                <option value="Super Admin">Super Admin</option>
                <option value="Basic Admin">Basic Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-dark"id="btn_update">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>
<!-- Edit Modal -->
<!-- Delete Modal -->
<div class="modal fade" id="delete_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{route("delete-user")}}" method="POST" enctype="multipart/form-data" id="delete-user-form">
            @csrf
        <div class="modal-header bg bg-dark">
          <h5 class="modal-title text-light" id="exampleModalLabel">Delete User</h5>
          <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="user_id" id="detele_user_id">
            <div class="form-group">
                <label for="name" class="">Are you sure you want to delete this user?</label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger"id="btn_delete">Delete</button>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>
<!-- Delete Modal -->

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
            ajax: "{{ route('get_users') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    print: true,
                    className: 'centered-text'
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true,
                    print: true,
                    className: 'centered-text'
                },
                {
                    data: 'email',
                    name: 'email',
                    orderable: true,
                    searchable: true,
                    print: true,
                    className: 'centered-text'
                },
                {
                    data: 'role',
                    name: 'role',
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

          //EDIT BUTTON ACTIONS
     $('body').on('click', '#edit', function() {
            var user_id = $(this).data('id');

            $.get('user/edit/' + user_id , function(data) {
                $("#user_id").val(user_id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#edit_model').modal('show');
            })
        });

         // DELETE BUTTON ACTIONS
     $('body').on('click', '#delete', function() {
            var user_id = $(this).data('id');
            $("#detele_user_id").val(user_id);
            $('#delete_model').modal('show');
         });


    //UPDATE USER ACTION
    $('#update-user-form').on('submit', function(event) {
            event.preventDefault();

            $("#btn_update").val('loading...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if(response.status === 'success') {
                        $('#edit_model').modal('hide');
                        toastr.success(response.message, 'Updated');
                       $('#edit_model').modal('hide');
                        $('.data-table').DataTable().ajax.reload();
                        window.location.reload();
                    } else {
                        $("#login_btn").val('Submit');
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(xhr) {
                    $("#login_btn").val('Submit');
                    toastr.error('An error occurred: ' + xhr.responseText);
                }
            });
        });
    });//END DOCUMENT READY FUNCTION
</script>
@endsection
