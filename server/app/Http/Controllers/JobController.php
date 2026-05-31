<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Services\JobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JobController extends Controller
{
    public function __construct(private JobService $jobService) {}

    /**
     * GET /api/jobs
     * List all jobs with optional search filter and pagination.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Job::query();

        if ($search = $request->input('filter.search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->latest()->paginate(15);

        return JobResource::collection($jobs);
    }

    /**
     * POST /api/jobs
     */
    public function store(JobRequest $request): JobResource
    {
        $job = Job::create($request->validated());

        return new JobResource($job);
    }

    /**
     * GET /api/jobs/{id}
     */
    public function show(Job $job): JobResource
    {
        return new JobResource($job);
    }

    /**
     * PUT/PATCH /api/jobs/{id}
     */
    public function update(JobRequest $request, Job $job): JobResource
    {
        $job->update($request->validated());

        return new JobResource($job);
    }

    /**
     * DELETE /api/jobs/{id}
     */
    public function destroy(Job $job): JsonResponse
    {
        $job->delete();

        return response()->json(['message' => 'Job deleted successfully.']);
    }
}
