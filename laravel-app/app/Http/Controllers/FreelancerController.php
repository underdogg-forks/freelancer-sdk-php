<?php

namespace App\Http\Controllers;

use FreelancerSdk\Session;
use FreelancerSdk\Resources\Projects\Projects;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FreelancerController extends Controller
{
    protected Session $session;
    protected Projects $projects;

    public function __construct(Session $session)
    {
        $this->session = $session;
        $this->projects = new Projects($session);
    }

    /**
     * Display a listing of projects
     */
    public function listProjects(Request $request): JsonResponse
    {
        try {
            $filters = [];
            
            if ($request->has('project_ids')) {
                $filters['projects[]'] = $request->input('project_ids');
            }
            
            if ($request->has('owner_ids')) {
                $filters['owners[]'] = $request->input('owner_ids');
            }

            $projects = $this->projects->getProjects($filters);

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Search for active projects
     */
    public function searchProjects(Request $request): JsonResponse
    {
        try {
            $filters = [];
            
            if ($request->has('query')) {
                $filters['query'] = $request->input('query');
            }
            
            if ($request->has('jobs')) {
                $filters['jobs[]'] = $request->input('jobs');
            }

            $projects = $this->projects->searchProjects($filters);

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get bids for a project
     */
    public function getBids(Request $request): JsonResponse
    {
        try {
            $filters = [];
            
            if ($request->has('project_ids')) {
                $filters['projects[]'] = $request->input('project_ids');
            }

            $bids = $this->projects->getBids($filters);

            return response()->json([
                'success' => true,
                'data' => $bids,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new project
     */
    public function createProject(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'description' => 'required|string',
                'currency' => 'required|array',
                'budget' => 'required|array',
                'jobs' => 'required|array',
            ]);

            $project = $this->projects->createProject($validated);

            return response()->json([
                'success' => true,
                'data' => $project,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Place a bid on a project
     */
    public function placeBid(Request $request, int $projectId): JsonResponse
    {
        try {
            $validated = $request->validate([
                'amount' => 'required|numeric',
                'period' => 'required|integer',
                'description' => 'required|string',
            ]);

            $bid = $this->projects->placeBid($projectId, $validated);

            return response()->json([
                'success' => true,
                'data' => $bid,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
