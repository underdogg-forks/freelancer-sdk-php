<?php

namespace FreelancerSdk\Resources\Projects;

use FreelancerSdk\Exceptions\Projects\BidNotPlacedException;
use FreelancerSdk\Exceptions\Projects\BidsNotFoundException;
use FreelancerSdk\Exceptions\Projects\ProjectNotCreatedException;
use FreelancerSdk\Exceptions\Projects\ProjectsNotFoundException;
use FreelancerSdk\Exceptions\Projects\JobsNotFoundException;
use FreelancerSdk\Types\Bid;
use FreelancerSdk\Types\Project;

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

    /**
     * Get a project by id
     *
     * @param int $projectId
     * @return Project
     * @throws ProjectsNotFoundException
     */
    public function getProject(int $projectId): Project
    {
        try {
            $response = $this->makeGetRequest('projects/' . $projectId);
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                $data = $response['result'];
                // Some responses wrap in 'projects' array
                if (isset($data['projects']) && is_array($data['projects']) && count($data['projects']) > 0) {
                    return new Project($data['projects'][0]);
                }
                return new Project($data);
            }
            throw new ProjectsNotFoundException($response['message'] ?? 'Project not found');
        } catch (\Exception $e) {
            if ($e instanceof ProjectsNotFoundException) {
                throw $e;
            }
            throw new ProjectsNotFoundException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Update a project
     *
     * @param int $projectId
     * @param array $data
     * @return Project
     * @throws ProjectNotCreatedException
     */
    public function updateProject(int $projectId, array $data): Project
    {
        try {
            $response = $this->makePutRequest('projects/' . $projectId, $data);
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                return new Project($response['result']);
            }
            throw new ProjectNotCreatedException($response['message'] ?? 'Failed to update project');
        } catch (\Exception $e) {
            if ($e instanceof ProjectNotCreatedException) {
                throw $e;
            }
            throw new ProjectNotCreatedException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Delete/Cancel a project
     *
     * @param int $projectId
     * @return bool
     * @throws ProjectsNotFoundException
     */
    public function deleteProject(int $projectId): bool
    {
        try {
            $response = $this->makeDeleteRequest('projects/' . $projectId);
            if (isset($response['status']) && $response['status'] === 'success') {
                return true;
            }
            throw new ProjectsNotFoundException($response['message'] ?? 'Failed to delete project');
        } catch (\Exception $e) {
            if ($e instanceof ProjectsNotFoundException) {
                throw $e;
            }
            throw new ProjectsNotFoundException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Update a bid on a project
     *
     * @param int $bidId
     * @param array $data
     * @return Bid
     * @throws BidNotPlacedException
     */
    public function updateBid(int $bidId, array $data): Bid
    {
        try {
            $response = $this->makePutRequest('bids/' . $bidId, $data);
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                return new Bid($response['result']);
            }
            throw new BidNotPlacedException($response['message'] ?? 'Failed to update bid');
        } catch (\Exception $e) {
            if ($e instanceof BidNotPlacedException) {
                throw $e;
            }
            throw new BidNotPlacedException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Retract a bid
     *
     * @param int $bidId
     * @return bool
     * @throws BidNotRetractedException
     */
    public function retractBid(int $bidId): bool
    {
        try {
            $response = $this->makeDeleteRequest('bids/' . $bidId);
            if (isset($response['status']) && $response['status'] === 'success') {
                return true;
            }
            throw new \FreelancerSdk\Exceptions\Projects\BidNotRetractedException($response['message'] ?? 'Failed to retract bid');
        } catch (\Exception $e) {
            if ($e instanceof \FreelancerSdk\Exceptions\Projects\BidNotRetractedException) {
                throw $e;
            }
            throw new \FreelancerSdk\Exceptions\Projects\BidNotRetractedException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Get list of jobs
     *
     * @param array $filters
     * @return array
     * @throws JobsNotFoundException
     */
    public function getJobs(array $filters = []): array
    {
        try {
            $response = $this->makeGetRequest('jobs', $filters);
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                return $response['result'];
            }
            throw new JobsNotFoundException($response['message'] ?? 'Jobs not found');
        } catch (\Exception $e) {
            if ($e instanceof JobsNotFoundException) {
                throw $e;
            }
            throw new JobsNotFoundException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }
}
