@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Create') }}</div>
                <div class="card-body">
                    <form action="{{ route('assignments.store') }}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            @include('assignments._form', ['buttonText' => 'Save'])
                        </div>
                    </form>
                </div>
            </div>

    </div>
</div>
@endsection
