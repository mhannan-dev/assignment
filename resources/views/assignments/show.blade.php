@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __('Assignment Details') }}
                    <a class="float-end btn btn-outline-success" href="{{ url('assignments/create') }}">New Assignment</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Type</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Class</th>
                                <th scope="col">Marks</th>
                                <th scope="col">Description</th>
                                <th scope="col">Assign date</th>
                                <th scope="col">Submission date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $item['type'] }}</td>
                                <td>{{ $item['subject']['title'] }}</td>
                                <td>{{ $item['class']['title'] ?? '' }}</td>
                                <td>{{ $item['marks'] ?? '' }}</td>
                                <td>{{ $item['description'] ?? '' }}</td>
                                <td>{{ date('Y-m-d', strtotime($item['assign_date'])) }}</td>
                                <td>{{ date('Y-m-d', strtotime($item['submission_date'])) }}</td>
                                <td>{{ $item['status'] ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    {{ __('Assignment Files') }}
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">File</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($item['files'] as $key => $myFile)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $myFile->files }}</td>
                                <td>
                                    <a href="{{ route('files.download', [$myFile->files]) }}" class="btn btn-success btn-sm">Download</a>
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
