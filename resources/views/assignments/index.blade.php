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
                        {{ __('Assignments') }}
                        <div class="float-end d-flex">
                            <form class="inline-form" action="{{ route('filter') }}" method="GET">
                                <div class="filter1">
                                    <select class="form-control" name="subject_id">
                                        <option value="" selected>Choose subject</option>
                                        @foreach ($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter1">
                                    <select class="form-control" name="class_model_id">
                                        <option value="" selected>Choose class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="filter1">
                                    <select class="form-control" name="status">
                                        <option value="" selected>Choose status</option>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                        <option value="overdue">Overdue</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary filter1">Filter</button>
                            </form>
                            <a class="btn btn-outline-success" href="{{ url('assignments/create') }}">New Assignment</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Class</th>
                                    <th scope="col">Marks</th>
                                    <th scope="col">Update status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assignments as $key => $item)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $item['type'] }}</td>
                                        <td>{{ $item['subject']['title'] }}</td>
                                        <td>{{ $item['class']['title'] ?? '' }}</td>
                                        <td>{{ $item['marks'] ?? '' }}</td>
                                        <td>
                                            <select class="form-control statusElement" id="statusElement"
                                                assignment_id="{{ $item['id'] }}">
                                                <option value="pending" disabled="disabled"
                                                    {{ $item['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="completed"
                                                    {{ $item['status'] == 'completed' ? 'selected' : '' }}>Completed
                                                </option>
                                                <option value="overdue"
                                                    {{ $item['status'] == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                            </select>
                                        </td>
                                        <td>
                                            <a href="{{ route('assignments.show', $item['id']) }}"
                                                class="btn btn-sm btn-primary">Details</a>
                                            <a href="{{ route('assignments.edit', $item['id']) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form style="display: inline-block"
                                                action="{{ route('assignments.destroy', $item['id']) }}"
                                                class="form-delete" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                            <a href="" class="btn btn-sm btn-info">Add Files</a>
                                            <a href="{{ route('file.download', [$item['image']]) }}"
                                                class="btn btn-sm btn-success">Download File</a>
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
            $('.statusElement').change(function() {
                var selectedValue = $(this).val();
                var assignment_id = $(this).attr("assignment_id");

                $.ajax({
                    url: "{{ route('ajax.status') }}",
                    method: "POST",
                    data: {
                        selectedValue: selectedValue,
                        assignment_id: assignment_id,
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            // Flash success message
                            let message = response.message;
                            var alertClass = response.status === 200 ? 'alert-success alert-dismissible fade show' :
                                'alert-danger alert-dismissible fade show';
                            var alertMessage = '<div class="alert ' + alertClass + '">' +
                                message + '</div>';
                            $('.alertMessage').html(alertMessage).show();

                            setTimeout(function() {
                                $('.alertMessage').fadeOut('slow', function() {
                                    $(this).hide();
                                });
                            }, 3000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log();(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
