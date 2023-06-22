@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">{{ __('Add more files') }}</div>
            <div class="card-body">
                <form action="{{ route('add.files', $assignment['id']) }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Attachments <span class="text-danger">*</span></label>
                                <input type="file" name="attachment[]" class="form-control {{ $errors->has('attachment') ? 'is-invalid' : '' }}" multiple>

                                @if ($errors->has('attachment'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('attachment') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
