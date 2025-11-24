<?php

namespace FreelancerSdk\Resources\Projects;

use FreelancerSdk\Exceptions\Projects\ProjectNotCreatedException;
use FreelancerSdk\Exceptions\Projects\ProjectsNotFoundException;
use FreelancerSdk\Exceptions\Projects\BidNotPlacedException;
use FreelancerSdk\Exceptions\Projects\BidsNotFoundException;
use FreelancerSdk\Resources\Projects\Project;
use FreelancerSdk\Resources\Projects\Bid;

/**
 * Projects resource class
 * Handles all project-related API operations
 */
class Projects extends ProjectsBase
{
    /**
     * Create a new project
     *
     * @param array $data Project data including title, description, currency, budget, jobs
     * @return Project
     * @throws ProjectNotCreatedException
     */
    public function createProject(array $data): Project
    {
        try {
            $response = $this->makePostRequest('projects', $data);
            
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                $project = new Project($response['result']);
                if (isset($project->seo_url)) {
                    $project->url = rtrim($this->session->getUrl(), '/') . '/projects/' . $project->seo_url;
                }
                return $project;
            }
            
            throw new ProjectNotCreatedException(
                $response['message'] ?? 'Failed to create project',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (\Exception $e) {
            if ($e instanceof ProjectNotCreatedException) {
                throw $e;
            }
            throw new ProjectNotCreatedException(
                $e->getMessage(),
                errorCode: null,
                requestId: null,
                code: $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Get projects by various filters
     *
     * @param array $filters
     * @return array
     * @throws ProjectsNotFoundException
     */
    public function getProjects(array $filters = []): array
    {
        try {
            $response = $this->makeGetRequest('projects', $filters);
            
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                $projects = [];
                if (isset($response['result']['projects'])) {
                    foreach ($response['result']['projects'] as $projectData) {
                        $projects[] = new Project($projectData);
                    }
                }
                return $projects;
            }
            
            throw new ProjectsNotFoundException(
                $response['message'] ?? 'Projects not found',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (\Exception $e) {
            if ($e instanceof ProjectsNotFoundException) {
                throw $e;
            }
            throw new ProjectsNotFoundException(
                $e->getMessage(),
                errorCode: null,
                requestId: null,
                code: $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Place a bid on a project
     *
     * @param int $projectId
     * @param array $bidData
     * @return Bid
     * @throws BidNotPlacedException
     */
    public function placeBid(int $projectId, array $bidData): Bid
    {
        try {
            $bidData['project_id'] = $projectId;
            $response = $this->makePostRequest('bids', $bidData);
            
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                return new Bid($response['result']);
            }
            
            throw new BidNotPlacedException(
                $response['message'] ?? 'Failed to place bid',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (\Exception $e) {
            if ($e instanceof BidNotPlacedException) {
                throw $e;
            }
            throw new BidNotPlacedException(
                $e->getMessage(),
                errorCode: null,
                requestId: null,
                code: $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Get bids for a project
     *
     * @param array $filters
     * @return array
     * @throws BidsNotFoundException
     */
    public function getBids(array $filters = []): array
    {
        try {
            $response = $this->makeGetRequest('bids', $filters);
            
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                $bids = [];
                if (isset($response['result']['bids'])) {
                    foreach ($response['result']['bids'] as $bidData) {
                        $bids[] = new Bid($bidData);
                    }
                }
                return $bids;
            }
            
            throw new BidsNotFoundException(
                $response['message'] ?? 'Bids not found',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (\Exception $e) {
            if ($e instanceof BidsNotFoundException) {
                throw $e;
            }
            throw new BidsNotFoundException(
                $e->getMessage(),
                errorCode: null,
                requestId: null,
                code: $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * Search for projects
     *
     * @param array $filters
     * @return array
     * @throws ProjectsNotFoundException
     */
    public function searchProjects(array $filters = []): array
    {
        try {
            $response = $this->makeGetRequest('projects/active', $filters);
            
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                $projects = [];
                if (isset($response['result']['projects'])) {
                    foreach ($response['result']['projects'] as $projectData) {
                        $projects[] = new Project($projectData);
                    }
                }
                return $projects;
            }
            
            throw new ProjectsNotFoundException(
                $response['message'] ?? 'Projects not found',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (\Exception $e) {
            if ($e instanceof ProjectsNotFoundException) {
                throw $e;
            }
            throw new ProjectsNotFoundException(
                $e->getMessage(),
                errorCode: null,
                requestId: null,
                code: $e->getCode(),
                previous: $e
            );
        }
    }
}
