@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Assignments') }}
                    <a class="float-end btn btn-outline-success" href="{{ url('assignments/create') }}">New Assignment</a>
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

                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $item['type'] }}</td>
                                <td>{{ $item['subject']['title'] }}</td>
                                <td>{{ $item['class']['title'] ?? "" }}</td>
                                <td>{{ $item['marks'] ?? "" }}</td>

                                <td>
                                    <a href="{{ route('assignments.show', $item['id']) }}" class="btn btn-sm btn-primary">Details</a>
                                    <a href="" class="btn btn-sm btn-warning">Edit</a>
                                    <form style="display: inline-block" action="{{ route('assignments.destroy', $item['id']) }}" class="form-delete" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                    <a href="" class="btn btn-sm btn-info">Add Files</a>
                                    <a href="{{ route('file.download', [$item['image']]) }}" class="btn btn-sm btn-success">Download File</a>
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
