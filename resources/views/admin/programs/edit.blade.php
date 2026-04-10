@extends('layouts.admin')

@section('title', 'Edit Program')
@section('page-title', 'Edit Program')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Program: {{ $program->title }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.programs.update', $program) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Program Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ $program->title }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Program Type</label>
                    <select name="type" class="form-select">
                        <option value="undergraduate" {{ $program->type == 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                        <option value="postgraduate" {{ $program->type == 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Icon Class</label>
                    <input type="text" name="icon" class="form-control" value="{{ $program->icon }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Duration (Years)</label>
                    <input type="number" name="duration_years" class="form-control" value="{{ $program->duration_years }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Credit Hours</label>
                    <input type="number" name="credit_hours" class="form-control" value="{{ $program->credit_hours }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">ECTS</label>
                    <input type="number" name="ects" class="form-control" value="{{ $program->ects }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Semesters</label>
                    <input type="number" name="semesters" class="form-control" value="{{ $program->semesters }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $program->description }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Career Opportunities (comma separated)</label>
                    <input type="text" name="career_opportunities" class="form-control" value="{{ is_array($program->career_opportunities) ? implode(',', $program->career_opportunities) : '' }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Specializations (comma separated)</label>
                    <input type="text" name="specializations" class="form-control" value="{{ is_array($program->specializations) ? implode(',', $program->specializations) : '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mode of Delivery</label>
                    <input type="text" name="mode_of_delivery" class="form-control" value="{{ $program->mode_of_delivery }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Teaching Method</label>
                    <input type="text" name="teaching_method" class="form-control" value="{{ $program->teaching_method }}">
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $program->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Program</button>
                <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection