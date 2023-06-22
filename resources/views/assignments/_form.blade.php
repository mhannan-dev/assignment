@csrf
<div class="col-md-4">
    <div class="mb-3">
        <div class="form-group">
            <label>Type<span class="text-danger">*</span> </label>
            <input type="text" name="type" class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" placeholder="Assignent type" value="{{ old('type', $assignment->type) }}">
            @if ($errors->has('type'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('type') }}</strong>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="mb-3">
        <div class="form-group">
            <label>Assigned by<span class="text-danger">*</span> </label>
            <input type="text" class="form-control {{ $errors->has('assigned_by') ? 'is-invalid' : '' }}" placeholder="Assigned by" name="assigned_by"  value="{{ old('assigned_by', $assignment->assigned_by) }}">

            @if ($errors->has('assigned_by'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('assigned_by') }}</strong>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="mb-3">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Class<span class="text-danger">*</span> </label>
            <select class="form-control {{ $errors->has('class_model_id') ? 'is-invalid' : '' }}" name="class_model_id">
                <option value="">-- @lang('Select') --</option>
                @foreach ($class as $item)
                <option value="{{ $item->id }}" @if (!empty($assignment['class_model_id']) &&
                $assignment['class_model_id']==$item->id) selected @endif>{{ $item->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('class_model_id'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('class_model_id') }}</strong>
            </div>
            @endif

        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="mb-3">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Section<span class="text-danger">*</span> </label>
            <select name="section_id" class="form-control {{ $errors->has('section_id') ? 'is-invalid' : '' }}">
                <option value="">-- @lang('Select') --</option>
                @foreach ($sections as $item)
                <option value="{{ $item->id }}" @if (!empty($assignment['section_id']) &&
                $assignment['section_id']==$item->id) selected @endif>{{ $item->title }}</option>
                @endforeach
            </select>

            @if ($errors->has('section_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('section_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="mb-3">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Subject<span class="text-danger">*</span> </label>
            <select class="form-control {{ $errors->has('subject_id') ? 'is-invalid' : '' }}" name="subject_id">
                <option value="">-- @lang('Select') --</option>
                @foreach ($subjects as $item)
                <option value="{{ $item->id }}" @if (!empty($assignment['subject_id']) &&
                $assignment['subject_id']==$item->id) selected @endif>{{ $item->title }}</option>
                @endforeach
            </select>
            @if ($errors->has('subject_id'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('subject_id') }}</strong>
            </div>
            @endif

        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="mb-3">
        <label class="form-label">Assign date <span class="text-danger">*</span> </label>


        <input type="date" class="form-control {{ $errors->has('assign_date') ? 'is-invalid' : '' }}" name="assign_date" value="{{ old('assign_date', formatDate($assignment->assign_date)) }}">

        @if ($errors->has('assign_date'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('assign_date') }}</strong>
        </div>
        @endif
    </div>
</div>

<div class="col-md-4">
    <div class="mb-3">
        <label class="form-label">Submission date<span class="text-danger">*</span> </label>
        <input type="date" class="form-control {{ $errors->has('submission_date') ? 'is-invalid' : '' }}" name="submission_date" value="{{ old('submission_date', formatDate($assignment->submission_date)) }}">

        @if ($errors->has('submission_date'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('submission_date') }}</strong>
        </div>
        @endif

    </div>
</div>
<div class="col-md-4">
    <div class="mb-3">
        <label class="form-label">Marks<span class="text-danger">*</span> </label>
        <input type="number" name="marks" value="{{ old('marks', $assignment->marks) }}" min="1" max="100" class="form-control {{ $errors->has('marks') ? 'is-invalid' : '' }}" placeholder="55">
        @if ($errors->has('marks'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('marks') }}</strong>
        </div>
        @endif

    </div>
</div>
<div class="col-md-4">
    <div class="mb-3">
        <label class="form-label">Attachments <span class="text-danger">*</span></label>
        <input type="file" name="attachment" class="form-control {{ $errors->has('attachment') ? 'is-invalid' : '' }}">

        @if ($errors->has('attachment'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('attachment') }}</strong>
        </div>
        @endif


    </div>
</div>
<div class="col-md-12">
    <div class="mb-3">
        <label class="form-label">Description<span class="text-danger">*</span> </label>
        <textarea  class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="3" placeholder="Description" name="description">{{ old('description', $assignment->description) }}</textarea>
        @if ($errors->has('description'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('description') }}</strong>
        </div>
        @endif
    </div>
</div>
<button type="submit" class="btn btn-success">{{ $buttonText }}</button>

