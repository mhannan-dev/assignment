@extends('layouts.app')
@push('styles')
    <style>
        .filter1 {
            margin-right: 10px;
        }

        .inline-form {
            display: -webkit-inline-box;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ __('Users') }}
                        <div class="float-end d-flex">
                            <a class="btn btn-outline-success" href="{{ url('users/create') }}">New User</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Change Role</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $item)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['email'] }}</td>
                                        <td>
                                            @if ($item['id'] != 1)
                                                <select class="form-control" id="userRoleChange"
                                                    user_id="{{ $item['id'] }}">
                                                    <option value="admin" {{ $item['type'] == 'admin' ? 'selected' : '' }}>
                                                        Admin
                                                    </option>
                                                    <option value="manager"
                                                        {{ $item['type'] == 'manager' ? 'selected' : '' }}>
                                                        Manager</option>
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $item['id']) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form style="display: inline-block"
                                                action="{{ route('users.destroy', $item['id']) }}" class="form-delete"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">No Data Found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#userRoleChange').change(function() {
                var selectedValue = $(this).val();
                var user_id = $(this).attr("user_id");
                $.ajax({
                    url: "{{ route('role.status') }}",
                    method: "POST",
                    data: {
                        selectedValue: selectedValue,
                        user_id: user_id,
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            // Flash success message
                            let message = response.message;
                            var alertClass = response.status === 200 ? 'alert-success alert-dismissible fade show' :
                                'alert-danger alert-dismissible fade show';
                            var alertMessage = '<div class="alert ' + alertClass + '">' +
                                message + '</div>';
                            $('#alertMessage').html(alertMessage).show();

                            setTimeout(function() {
                                $('#alertMessage').fadeOut('slow', function() {
                                    $(this).hide();
                                });
                            }, 3000); // Hide after 3 seconds (adjust as needed)
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            setTimeout(function() {
                $('.flashMessage').fadeOut('fast');
            }, 1500); // <-- time in milliseconds
        });
    </script>
@endpush
