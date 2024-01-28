@extends('layouts.master')
@section('title', 'Job')
@section('page-css')
    <style type="text/css">
        .card-top {
            margin-bottom: 30px;
        }

        .general-button {
            width: 150px;
        }

        .company-logo {
            width: 100%;
            min-height: auto;
            max-height: 200px;
            object-fit: cover;
        }

        .marquee-container {
            width: 100%;
            overflow: hidden;
        }

        .marquee {
            display: inline-block;
            white-space: nowrap;
            animation: scroll 4s linear infinite;
        }

        @keyframes scroll {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-family: "Open Sans", sans-serif;
        }
    </style>
@endsection
@section('main')
    @if(count($jobs))
        <div class="row">
            @foreach ($jobs as $index => $job)
                <div class="card col-12 col-lg-10 offset-lg-1 p-3 rounded-3 shadow-sm">
                    <div class="row mb-3">
                        <div class="col-12 col-md-2">
                            <img class="img-fluid rounded-3 border border-1 border-light company-logo" src="{{ asset('images/jobs/'.$job->company_logo) }}" alt="{{ $job->company_name }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex flex-column">
                                <h3>
                                    <a class="fw-bold link-primary" data-bs-toggle="collapse" href="#job_{{ $index }}_details" role="button" aria-expanded="false" aria-controls="job_{{ $index }}_details">{{ $job->job_title }}</a>
                                </h3>
                                <div class="mb-3">
                                    <span class="badge rounded-pill bg-info">{{ $job->skill_level }}</span>
                                </div>
                                <div>
                                    <span class="text-muted">{{ $job->company_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 text-end">
                            <div>
                                <i class="fa-regular fa-clock"></i>
                                <span>Deadline : {{ \Carbon\Carbon::parse($job->deadline )->format('D, j M Y') }}</span>
                            </div>
                            @if(auth()->check() && auth()->user()->type == 'admin')
                                <div class="d-flex justify-content-end align-items-center">
                                    <a href="{{ route('job.edit', $job->id) }}" title="edit job details" class="text-warning fs-5">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <div class="form-check form-switch ms-3 mb-0" title="{{ $job->is_active ? 'Hide this Job' : 'Show this Job' }}">
                                        <input class="form-check-input activeToggler" type="checkbox" role="switch" id="active-toggle-{{$job->id}}" {{ $job->is_active ? 'checked' : '' }}>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md-8 text-center text-md-start">
                            <div class="d-inline-block bg-primary text-primary bg-opacity-10 py-2 px-3 my-1 rounded general-button">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-location-dot me-1"></i>
                                    <div class="marquee-container">
                                        <div class="marquee">
                                            <span>{{ $job->location }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block bg-danger text-danger bg-opacity-10 py-2 px-3 my-1 rounded general-button">
                                <i class="fa-solid fa-business-time me-1"></i>
                                <span>{{ $job->job_type }}</span>
                            </div>
                            <div class="d-inline-block bg-success text-success bg-opacity-10 py-2 px-3 my-1 rounded general-button">
                                <span class="fw-bold fs-6">&#2547;</span>
                                <span>{{ $job->basic_salary ?? 'Negotiable' }}</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mt-4 my-md-1 d-flex flex-column flex-sm-row">
                            <button class="btn btn-info text-light m-1" type="button" data-bs-toggle="collapse" data-bs-target="#job_{{ $index }}_details" aria-expanded="false" aria-controls="job_{{ $index }}_details">Details</button>
                            <a class="btn btn-primary m-1" href="{{ $job->apply_url }}" target="_blank">Apply Now</a>
                            @if(auth()->check() && auth()->user()->type == 'admin')
                                <form action="{{ route('job.destroy', $job->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger m-1 w-100">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="collapse" id="job_{{ $index }}_details">
                        <hr>
                        <div class="d-inline-block bg-info text-info bg-opacity-10 py-2 px-3 my-1 rounded">
                            <span>Total Vacancy : <strong>{{ $job->total_vacancy ?? 'Not Specified' }}</strong></span>
                        </div>
                        <div class="d-inline-block bg-info text-info bg-opacity-10 py-2 px-3 my-1 rounded">
                            <span>Job Industry : <strong>{{ $job->job_industry ?? 'Not Specified' }}</strong></span>
                        </div>
                        <hr>
                        <br>
                        <h5 class="fw-bold text-muted">Position Summary</h5>
                        <pre class="ms-4">{{ $job->jobRequirement?->position_summery ?? 'N/A' }}</pre>
                        <br>
                        <h5 class="fw-bold text-muted">Job Responsibilities</h5>
                        <pre class="ms-4">{{ $job->jobRequirement?->responsibilities ?? 'N/A' }}</pre>
                        <br>
                        <h5 class="fw-bold text-muted">Educational Requirements</h5>
                        <pre class="ms-4">{{ $job->jobRequirement?->educational ?? 'N/A' }}</pre>
                        <br>
                        <h5 class="fw-bold text-muted">Experience Requirements</h5>
                        <pre class="ms-4">{{ $job->jobRequirement?->experience ?? 'N/A' }}</pre>
                        <br>
                        <h5 class="fw-bold text-muted">Additional Requirements</h5>
                        <pre class="ms-4">{{ $job->jobRequirement?->additional ?? 'N/A' }}</pre>
                        <br>
                        <h5 class="fw-bold text-muted">Required Skills</h5>
                        <pre class="ms-4">{{ $job->jobRequirement?->skills ?? 'N/A' }}</pre>
                        <br>
                        <h5 class="fw-bold text-muted">Job Benefits</h5>
                        <pre class="ms-4">{{ $job->benefits ?? 'N/A' }}</pre>
                        <br>
                        <a class="btn btn-primary" href="{{ $job->apply_url }}" target="_blank">Apply Now</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            {{ $jobs->links() }}
        </div>
    @else
        <div class="mt-5 m-auto text-center" style="width: 200px">
            <img class="w-100 rounded" style="" src="{{ asset('images/courses/no-courses.svg') }}" alt="No Job Available">
            <h6 class="text-muted mt-3">No Job Available</h6>
        </div>
    @endif
@endsection

@section('page-js')
    <script>
        $(document).ready(function() {
            $('.activeToggler').change(function() {
                var jobId = $(this).attr('id').split('-')[2];
                $.ajax({
                    type: "POST",
                    url: "{{ route('job.ajax.active-toggle') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'jobId': jobId,
                    },
                    success: function(data) {
                        console.log('Toggle success');
                    },
                    error: function(data) {
                        console.log('Toggle error');
                    }
                });
            });
        });
    </script>
@endsection
