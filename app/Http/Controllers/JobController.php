<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobRequirement;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('jobRequirement');

        if (!auth()->check() || auth()->user()->type != 'admin')
            $jobs->where('deadline', '>=', now()->toDateString())
                ->where('is_active', true);

        $jobs = $jobs->orderByDesc('id')
                ->paginate(10);

        return view('job.index', compact('jobs'));
    }

    public function create()
    {
        $skill_levels = Job::SKILL_LEVELS;
        $job_types = Job::JOB_TYPES;

        return view('job.create', compact('skill_levels', 'job_types'));
    }

    public function store(Request $request)
    {
        if($request->company_logo) {
            $tmpName = str_replace(' ', '_', $request->company_logo->getClientOriginalName());
            $company_logoName = time().'_'.$tmpName;
            if(env('APP_ENV') == 'local') {
                $request->company_logo->move(public_path('images/jobs'), $company_logoName);
            }
            else {
                $request->company_logo->move('images/jobs', $company_logoName);
            }
        }
        else {
            $company_logoName = "default.png";
        }

        try {
            $job = Job::create([
                'job_title'         => $request->job_title,
                'skill_level'       => $request->skill_level,
                'company_name'      => $request->company_name,
                'company_logo'      => $company_logoName,
                'job_type'          => $request->job_type,
                'location'          => $request->location,
                'job_industry'      => $request->job_industry,
                'total_vacancy'     => $request->total_vacancy,
                'basic_salary'      => $request->basic_salary,
                'benefits'          => $request->benefits,
                'deadline'          => $request->deadline,
                'apply_url'         => $request->apply_url,
                'is_active'         => true,
            ]);

            return redirect()->route('job.edit', $job->id);
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function show(Job $job)
    {
        //
    }

    public function edit(Job $job)
    {
        $job = $job->load('jobRequirement');

        $skill_levels = Job::SKILL_LEVELS;
        $job_types = Job::JOB_TYPES;

        return view('job.edit', compact('job', 'skill_levels', 'job_types'));
    }

    public function update(Request $request, Job $job)
    {
        if($request->company_logo) {
            $tmpName = str_replace(' ', '_', $request->company_logo->getClientOriginalName());
            $company_logoName = time().'_'.$tmpName;
            if(env('APP_ENV') == 'local') {
                $request->company_logo->move(public_path('images/jobs'), $company_logoName);
            }
            else {
                $request->company_logo->move('images/jobs', $company_logoName);
            }
        }
        else {
            $company_logoName = $job->company_logo;
        }

        try {
            $job->update([
                'job_title'         => $request->job_title,
                'skill_level'       => $request->skill_level,
                'company_name'      => $request->company_name,
                'company_logo'      => $company_logoName,
                'job_type'          => $request->job_type,
                'location'          => $request->location,
                'job_industry'      => $request->job_industry,
                'total_vacancy'     => $request->total_vacancy,
                'basic_salary'      => $request->basic_salary,
                'benefits'          => $request->benefits,
                'deadline'          => $request->deadline,
                'apply_url'         => $request->apply_url,
                'is_active'         => $job->is_active,
            ]);

            return redirect()->route('job.edit', $job->id);
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function updateRequirement(Request $request, Job $job)
    {
        $job->load('jobRequirement');

        $updated_data = [
            'job_id'            => $job->id,
            'position_summery'  => $request->position_summery,
            'responsibilities'  => $request->responsibilities,
            'educational'       => $request->educational,
            'experience'        => $request->experience,
            'additional'        => $request->additional,
            'skills'            => $request->skills,
        ];

        try {
            if ($job->jobRequirement) {
                $job->jobRequirement->update($updated_data);
            } else {
                JobRequirement::create($updated_data);
            }

            return redirect()->route('job.edit', $job->id);
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function ajaxActiveToggle(Request $request)
    {
        $job = Job::find($request->jobId);
        if (!$job)
            return response()->json(['success' => false]);

        try {
            $job->update([
                'is_active' => !$job->is_active
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false]);
        }
    }

    public function destroy(Job $job)
    {
        if (!auth()->check() || auth()->user()->type != 'admin') return abort(401);
        $job->delete();

        return back();
    }
}
