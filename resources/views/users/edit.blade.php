@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">{{ __('Update') }}</div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="post">
                    @method('put')
                    <div class="row">
                        @include('users._form', ['buttonText' => 'Update'])
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
