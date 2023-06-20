@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create') }}</div>
                <div class="card-body">
                    <form action="{{ route('assignments.store') }}" method="post">
                        @include('assignments._form', ['buttonText' => 'Save'])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
