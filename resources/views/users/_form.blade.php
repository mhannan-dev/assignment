@csrf
<div class="col-md-6">
    <div class="mb-3">
        <div class="form-group">
            <label>Type<span class="text-danger">*</span></label>
            <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type">
                <option value="">-- @lang('Select') --</option>
                <option value="manager" @if ($user['type'] == "manager") selected @endif>Manager</option>
                <option value="admin">Admin</option>
            </select>

            @if ($errors->has('type'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="mb-3">
        <div class="form-group">
            <label>Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                placeholder="User name" name="name" value="{{ old('name', $user->name) }}">

            @if ($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="mb-3">
        <div class="form-group">
            <label>Email<span class="text-danger">*</span></label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                placeholder="User name" name="email" value="{{ old('email', $user->email) }}">

            @if ($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="mb-3">
        <div class="form-group">
            <label>Password<span class="text-danger">*</span></label>
            <input type="text" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="Password" name="password" value="{{ old('password') }}">

            @if ($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>

<button type="submit" class="btn btn-success">{{ $buttonText }}</button>
