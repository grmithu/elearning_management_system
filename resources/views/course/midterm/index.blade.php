@extends('layouts.master')
@section('title', 'Midterm Mark')
@section('page-css')
    <style type="text/css">
        .card-top {
            margin-bottom: 30px;
        }
        .course-instructor-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            top: 100%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endsection
@section('main')
    @include('components.course-header')
    @if (count($course->enrollees))
        <div class="card p-3">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title pb-0 fs-4">Midterm Mark</h5>
            </div>
            <div class="card-body mt-4 table-responsive">
                <table class="table table-striped table-hover table-bordered shadow-sm">
                    <thead class="bg-secondary text-light">
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Obtained Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($course->enrollees as $enrollee)
                        <tr class="{{ auth()->id() == $enrollee->id ? 'bg-success-light' : '' }}">
                            <th class="align-middle" scope="col">{{ $enrollee->username }}</th>
                            <td class="align-middle">
                                <a href="{{ route('profile.show', $enrollee->id) }}">
                                    {{ $enrollee->name }}
                                </a>
                            </td>
                            <td class="align-middle">{{ $enrollee->email }}</td>
                            <td class="align-middle fw-bold">
                                @if(auth()->id() == $course->instructor?->id)
                                    <form class="g-3 needs-validation" action="{{ route('midterm.store.mark-release', $course->id) }}" method="POST" novalidate>
                                        @csrf
                                        <div class="d-inline-block">
                                            <input type="hidden" name="student_id" value="{{ $enrollee->id }}" required>
                                            <input type="number" step="any" name="obtained_mark" class="form-control @error('obtained_mark') is-invalid @enderror" value="{{ old('obtained_mark') ?? $course->midtermMarks->where('participant_id', $enrollee->id)->first()?->obtained_marks }}" required>
                                        </div>
                                        <div class="d-inline-block">
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 shadow-sm border border-2 border-light text-nowrap">Update Mark</button>
                                        </div>
                                    </form>
                                @else
                                    {{ $course->midtermMarks->where('participant_id', $enrollee->id)->first()?->obtained_marks ?? 'N/A' }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="mt-5 m-auto text-center" style="width: 200px">
            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Student available yet">
            <h6 class="text-muted mt-3">No Student Available yet</h6>
        </div>
    @endif
@endsection
