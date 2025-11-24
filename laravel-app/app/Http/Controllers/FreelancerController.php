<?php

namespace App\Http\Controllers;

use FreelancerSdk\Resources\Projects\Projects;
use FreelancerSdk\Exceptions\Projects\ProjectNotCreatedException;
use FreelancerSdk\Exceptions\Projects\ProjectsNotFoundException;
use FreelancerSdk\Exceptions\Projects\BidNotPlacedException;
use FreelancerSdk\Exceptions\Projects\BidsNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FreelancerController extends Controller
{
    protected Projects $projects;

    public function __construct(Projects $projects)
    {
        $this->projects = $projects;
    }

    /**
     * Display a listing of projects
     */
    public function listProjects(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'project_ids' => 'sometimes|array',
            'project_ids.*' => 'integer',
            'owner_ids' => 'sometimes|array',
            'owner_ids.*' => 'integer',
        ]);

        try {
            $filters = [];
            
            if (isset($validated['project_ids'])) {
                $filters['projects[]'] = $validated['project_ids'];
            }
            
            if (isset($validated['owner_ids'])) {
                $filters['owners[]'] = $validated['owner_ids'];
            }

            $projects = $this->projects->getProjects($filters);

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (ProjectsNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
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
        $validated = $request->validate([
            'query' => 'sometimes|string',
            'jobs' => 'sometimes|array',
            'jobs.*' => 'integer',
        ]);

        try {
            $filters = [];
            
            if (isset($validated['query'])) {
                $filters['query'] = $validated['query'];
            }
            
            if (isset($validated['jobs'])) {
                $filters['jobs[]'] = $validated['jobs'];
            }

            $projects = $this->projects->searchProjects($filters);

            return response()->json([
                'success' => true,
                'data' => $projects,
            ]);
        } catch (ProjectsNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
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
        $validated = $request->validate([
            'project_ids' => 'sometimes|array',
            'project_ids.*' => 'integer',
        ]);

        try {
            $filters = [];
            
            if (isset($validated['project_ids'])) {
                $filters['projects[]'] = $validated['project_ids'];
            }

            $bids = $this->projects->getBids($filters);

            return response()->json([
                'success' => true,
                'data' => $bids,
            ]);
        } catch (BidsNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
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
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'currency' => 'required|array',
            'budget' => 'required|array',
            'jobs' => 'required|array',
        ]);

        try {
            $project = $this->projects->createProject($validated);

            return response()->json([
                'success' => true,
                'data' => $project,
            ], 201);
        } catch (ProjectNotCreatedException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
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
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'period' => 'required|integer',
            'description' => 'required|string',
        ]);

        try {
            $bid = $this->projects->placeBid($projectId, $validated);

            return response()->json([
                'success' => true,
                'data' => $bid,
            ], 201);
        } catch (BidNotPlacedException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
