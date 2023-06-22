@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">
                {{ __('Create user') }}
                <div class="float-end d-flex">
                <a class="btn btn-outline-success" href="{{ url('users') }}">Users</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="post">
                    <div class="row">
                        @include('users._form', ['buttonText' => 'Save'])
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
