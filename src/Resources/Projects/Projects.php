<?php

namespace FreelancerSdk\Resources\Projects;

use Exception;
use FreelancerSdk\Exceptions\Projects\BidNotPlacedException;
use FreelancerSdk\Exceptions\Projects\BidsNotFoundException;
use FreelancerSdk\Exceptions\Projects\JobsNotFoundException;
use FreelancerSdk\Exceptions\Projects\ProjectNotCreatedException;
use FreelancerSdk\Exceptions\Projects\ProjectsNotFoundException;
use FreelancerSdk\Types\Bid;
use FreelancerSdk\Types\Project;

/**
 * Projects resource class
 * Handles all project-related API operations.
 */
class Projects extends ProjectsBase
{
    /**
     * Create a new project with the provided data.
     *
     * If the created project contains a `seo_url`, the returned Project's `url` property
     * will be set to the full project URL based on the current session URL.
     *
     * @param array $data Project data (e.g., title, description, currency, budget, jobs).
     * @return Project The created Project instance.
     * @throws ProjectNotCreatedException When the API returns a failure response or the request cannot be completed.
     */
    public function createProject(array $data): Project
    {
        try {
            $response = $this->makePostRequest('projects', $data);

            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                $project = new Project($response['result']);
                if (isset($project->seo_url)) {
                    $project->url = mb_rtrim($this->session->getUrl(), '/') . '/projects/' . $project->seo_url;
                }

                return $project;
            }

            throw new ProjectNotCreatedException(
                $response['message']    ?? 'Failed to create project',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (Exception $e) {
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
         * Retrieve projects matching optional query filters.
         *
         * @param array $filters Optional associative filters applied to the projects query (e.g. category, budget, page).
         * @return Project[] An array of Project instances that match the provided filters.
         *
         * @throws ProjectsNotFoundException If the API response does not contain projects or an error occurs.
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
                $response['message']    ?? 'Projects not found',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (Exception $e) {
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
         * Place a bid on the specified project.
         *
         * Sends the provided bid data to the API for the given project and returns the created Bid.
         *
         * @param int   $projectId ID of the project to place the bid on.
         * @param array $bidData   Associative array of bid fields (for example: amount, cover_letter); keys depend on API.
         * @return Bid The created Bid instance.
         *
         * @throws BidNotPlacedException If the API fails to create the bid. The exception includes the API message, error code, and request ID when available.
         */
    public function placeBid(int $projectId, array $bidData): Bid
    {
        try {
            $bidData['project_id'] = $projectId;
            $response              = $this->makePostRequest('bids', $bidData);

            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                return new Bid($response['result']);
            }

            throw new BidNotPlacedException(
                $response['message']    ?? 'Failed to place bid',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (Exception $e) {
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
     * Retrieve bids matching the provided optional filters.
     *
     * @param array $filters Optional associative array of query parameters to filter bids (e.g., project_id, user_id, limit).
     * @return Bid[] An array of Bid instances matching the filters.
     * @throws BidsNotFoundException If the API response indicates failure or no bids were found.
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
                $response['message']    ?? 'Bids not found',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (Exception $e) {
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
     * Search active projects using optional query filters.
     *
     * @param array $filters Optional associative array of query parameters to filter the search.
     * @return Project[] An array of Project instances matching the search criteria.
     * @throws ProjectsNotFoundException When the API response indicates failure or no projects are found; exception contains API message, error code, and request id when available.
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
                $response['message']    ?? 'Projects not found',
                $response['error_code'] ?? null,
                $response['request_id'] ?? null
            );
        } catch (Exception $e) {
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
         * Retrieve a project by its ID.
         *
         * If the API response wraps the result in a `projects` array, the first item is returned.
         *
         * @param int $projectId The project identifier.
         *
         * @return Project The requested project.
         *
         * @throws ProjectsNotFoundException If the project cannot be found or the request fails.
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
        } catch (Exception $e) {
            if ($e instanceof ProjectsNotFoundException) {
                throw $e;
            }
            throw new ProjectsNotFoundException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Update an existing project with the provided data.
     *
     * @param int   $projectId ID of the project to update.
     * @param array $data      Associative array of project fields to update.
     *
     * @return Project The updated Project instance.
     *
     * @throws ProjectNotCreatedException If the project could not be updated; when wrapping other exceptions the original message, code, and previous exception are preserved.
     */
    public function updateProject(int $projectId, array $data): Project
    {
        try {
            $response = $this->makePutRequest('projects/' . $projectId, $data);
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                return new Project($response['result']);
            }
            throw new ProjectNotCreatedException($response['message'] ?? 'Failed to update project');
        } catch (Exception $e) {
            if ($e instanceof ProjectNotCreatedException) {
                throw $e;
            }
            throw new ProjectNotCreatedException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Delete (cancel) a project by its ID.
     *
     * @param int $projectId The ID of the project to delete.
     * @return bool `true` if the project was deleted.
     * @throws ProjectsNotFoundException If the project could not be deleted or the request failed.
     */
    public function deleteProject(int $projectId): bool
    {
        try {
            $response = $this->makeDeleteRequest('projects/' . $projectId);
            if (isset($response['status']) && $response['status'] === 'success') {
                return true;
            }
            throw new ProjectsNotFoundException($response['message'] ?? 'Failed to delete project');
        } catch (Exception $e) {
            if ($e instanceof ProjectsNotFoundException) {
                throw $e;
            }
            throw new ProjectsNotFoundException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
         * Update an existing bid.
         *
         * @param int   $bidId The identifier of the bid to update.
         * @param array $data  Associative array of fields to update on the bid.
         *
         * @return Bid The updated Bid instance.
         *
         * @throws BidNotPlacedException If the update is rejected or the request fails.
         */
    public function updateBid(int $bidId, array $data): Bid
    {
        try {
            $response = $this->makePutRequest('bids/' . $bidId, $data);
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                return new Bid($response['result']);
            }
            throw new BidNotPlacedException($response['message'] ?? 'Failed to update bid');
        } catch (Exception $e) {
            if ($e instanceof BidNotPlacedException) {
                throw $e;
            }
            throw new BidNotPlacedException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Retract a bid identified by its ID.
     *
     * @param int $bidId The identifier of the bid to retract.
     * @return bool `true` if the bid was successfully retracted.
     * @throws \FreelancerSdk\Exceptions\Projects\BidNotRetractedException If the retraction fails.
     */
    public function retractBid(int $bidId): bool
    {
        try {
            $response = $this->makeDeleteRequest('bids/' . $bidId);
            if (isset($response['status']) && $response['status'] === 'success') {
                return true;
            }
            throw new \FreelancerSdk\Exceptions\Projects\BidNotRetractedException($response['message'] ?? 'Failed to retract bid');
        } catch (Exception $e) {
            if ($e instanceof \FreelancerSdk\Exceptions\Projects\BidNotRetractedException) {
                throw $e;
            }
            throw new \FreelancerSdk\Exceptions\Projects\BidNotRetractedException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }

    /**
     * Retrieve jobs using optional filters.
     *
     * @param array $filters Optional query filters to apply to the jobs request.
     * @return array Array of jobs returned by the API.
     * @throws JobsNotFoundException When the API response indicates failure or no jobs were found.
     */
    public function getJobs(array $filters = []): array
    {
        try {
            $response = $this->makeGetRequest('jobs', $filters);
            if (isset($response['status']) && $response['status'] === 'success' && isset($response['result'])) {
                return $response['result'];
            }
            throw new JobsNotFoundException($response['message'] ?? 'Jobs not found');
        } catch (Exception $e) {
            if ($e instanceof JobsNotFoundException) {
                throw $e;
            }
            throw new JobsNotFoundException($e->getMessage(), code: $e->getCode(), previous: $e);
        }
    }
}