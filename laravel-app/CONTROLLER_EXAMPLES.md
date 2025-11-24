# FreelancerController API Examples

This document maps all Python SDK examples to Laravel controller endpoints. Many endpoints are stubbed and return `501 Not Implemented` until the corresponding SDK resources are created.

## Status Legend
- ✅ **Implemented**: Fully functional with SDK support
- 🚧 **Stub**: Controller method exists but SDK resource needed
- 📋 **Planned**: Variation of existing functionality

---

## Projects

### ✅ List Projects
**Python Example**: `examples/get_projects.py`  
**Endpoint**: `GET /freelancer/projects`

```bash
curl "http://localhost:8000/freelancer/projects?project_ids[]=123&project_ids[]=456"
```

```json
{
  "project_ids": [123, 456],
  "owner_ids": [789]
}
```

---

### ✅ Search Projects
**Python Example**: `examples/search_projects.py`  
**Endpoint**: `GET /freelancer/projects/search`

```bash
curl "http://localhost:8000/freelancer/projects/search?query=logo+design&jobs[]=59"
```

```json
{
  "query": "logo design",
  "jobs": [59, 3]
}
```

---

### ✅ Create Project
**Python Example**: `examples/create_project.py`  
**Endpoint**: `POST /freelancer/projects`

```bash
curl -X POST http://localhost:8000/freelancer/projects \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Build a Laravel App",
    "description": "Need experienced Laravel developer",
    "currency": {"id": 1},
    "budget": {"minimum": 500, "maximum": 1000},
    "jobs": [{"id": 7}]
  }'
```

---

### 📋 Create Hire-Me Project
**Python Example**: `examples/create_hireme_project.py`  
**Endpoint**: `POST /freelancer/projects/hireme`  
**Status**: 501 - Needs SDK extension

---

### 📋 Create Hourly Project
**Python Example**: `examples/create_hourly_project.py`  
**Endpoint**: `POST /freelancer/projects/hourly`  
**Status**: 501 - Needs SDK extension

---

### 📋 Create Local Project
**Python Example**: `examples/create_local_project.py`  
**Endpoint**: `POST /freelancer/projects/local`  
**Status**: 501 - Needs SDK extension

---

## Bids

### ✅ List Bids
**Python Example**: `examples/get_bids.py`  
**Endpoint**: `GET /freelancer/bids`

```bash
curl "http://localhost:8000/freelancer/bids?project_ids[]=123&project_ids[]=456"
```

---

### ✅ Place Bid
**Python Example**: `examples/place_project_bid.py`  
**Endpoint**: `POST /freelancer/projects/{projectId}/bids`

```bash
curl -X POST http://localhost:8000/freelancer/projects/123456/bids \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 750,
    "period": 14,
    "description": "I have extensive experience..."
  }'
```

---

### 🚧 Accept Bid
**Python Example**: `examples/accept_project_bid.py`  
**Endpoint**: `POST /freelancer/projects/{projectId}/bids/{bidId}/accept`  
**Status**: 501 - Needs SDK resource

---

### 🚧 Award Bid
**Python Example**: `examples/award_project_bid.py`  
**Endpoint**: `POST /freelancer/projects/{projectId}/bids/{bidId}/award`  
**Status**: 501 - Needs SDK resource

---

### 🚧 Retract Bid
**Python Example**: `examples/retract_project_bid.py`  
**Endpoint**: `DELETE /freelancer/bids/{bidId}/retract`  
**Status**: 501 - Needs SDK resource

---

### 🚧 Revoke Bid
**Python Example**: `examples/revoke_project_bid.py`  
**Endpoint**: `DELETE /freelancer/bids/{bidId}/revoke`  
**Status**: 501 - Needs SDK resource

---

### 🚧 Highlight Bid
**Python Example**: `examples/highlight_project_bid.py`  
**Endpoint**: `POST /freelancer/bids/{bidId}/highlight`  
**Status**: 501 - Needs SDK resource

---

## Users

### 🚧 Get Users
**Python Example**: `examples/get_users.py`  
**Endpoint**: `GET /freelancer/users`  
**Status**: 501 - Needs Users SDK resource

```bash
# When implemented:
curl "http://localhost:8000/freelancer/users?user_ids[]=110013&user_ids[]=221202"
```

---

### 🚧 Get Self (Current User)
**Python Example**: `examples/get_self.py`  
**Endpoint**: `GET /freelancer/users/self`  
**Status**: 501 - Needs Users SDK resource

```bash
# When implemented:
curl http://localhost:8000/freelancer/users/self
```

---

### 🚧 Search Freelancers
**Python Example**: `examples/search_freelancers.py`  
**Endpoint**: `GET /freelancer/users/search`  
**Status**: 501 - Needs Users SDK resource

```bash
# When implemented:
curl "http://localhost:8000/freelancer/users/search?query=design"
```

---

### 🚧 Add User Jobs
**Python Example**: `examples/add_user_jobs.py`  
**Endpoint**: `POST /freelancer/users/jobs`  
**Status**: 501 - Needs Users SDK resource

---

### 🚧 Set User Jobs
**Python Example**: `examples/set_user_jobs.py`  
**Endpoint**: `PUT /freelancer/users/jobs`  
**Status**: 501 - Needs Users SDK resource

---

### 🚧 Delete User Jobs
**Python Example**: `examples/delete_user_jobs.py`  
**Endpoint**: `DELETE /freelancer/users/jobs`  
**Status**: 501 - Needs Users SDK resource

---

### 🚧 Get Portfolios
**Python Example**: `examples/get_portfolios.py`  
**Endpoint**: `GET /freelancer/portfolios`  
**Status**: 501 - Needs Users SDK resource

---

### 🚧 Get Reputations
**Python Example**: `examples/get_reputations.py`  
**Endpoint**: `GET /freelancer/reputations`  
**Status**: 501 - Needs Users SDK resource

---

## Milestones

### 🚧 Get Milestones
**Python Example**: `examples/get_milestones.py`  
**Endpoint**: `GET /freelancer/milestones`  
**Status**: 501 - Needs Milestones SDK resource

```bash
# When implemented:
curl "http://localhost:8000/freelancer/milestones?project_ids[]=123"
```

---

### 🚧 Get Specific Milestone
**Python Example**: `examples/get_specific_milestone.py`  
**Endpoint**: `GET /freelancer/milestones/{milestoneId}`  
**Status**: 501 - Needs Milestones SDK resource

---

### 🚧 Create Milestone Payment
**Python Example**: `examples/create_milestone_payment.py`  
**Endpoint**: `POST /freelancer/milestones`  
**Status**: 501 - Needs Milestones SDK resource

```bash
# When implemented:
curl -X POST http://localhost:8000/freelancer/milestones \
  -H "Content-Type: application/json" \
  -d '{
    "project_id": 123456,
    "bidder_id": 789,
    "amount": 100,
    "description": "First milestone"
  }'
```

---

### 🚧 Create Milestone Request
**Python Example**: `examples/create_milestone_request.py`  
**Endpoint**: `POST /freelancer/milestones/request`  
**Status**: 501 - Needs Milestones SDK resource

---

### 🚧 Accept Milestone Request
**Python Example**: `examples/accept_milestone_request.py`  
**Endpoint**: `POST /freelancer/milestones/{milestoneId}/accept`  
**Status**: 501 - Needs Milestones SDK resource

---

### 🚧 Reject Milestone Request
**Python Example**: `examples/reject_milestone_request.py`  
**Endpoint**: `POST /freelancer/milestones/{milestoneId}/reject`  
**Status**: 501 - Needs Milestones SDK resource

---

### 🚧 Delete Milestone Request
**Python Example**: `examples/delete_milestone_request.py`  
**Endpoint**: `DELETE /freelancer/milestones/{milestoneId}/request`  
**Status**: 501 - Needs Milestones SDK resource

---

### 🚧 Release Milestone Payment
**Python Example**: `examples/release_milestone_payment.py`  
**Endpoint**: `POST /freelancer/milestones/{milestoneId}/release`  
**Status**: 501 - Needs Milestones SDK resource

---

### 🚧 Request Release Milestone Payment
**Python Example**: `examples/request_release_milestone_payment.py`  
**Endpoint**: `POST /freelancer/milestones/{milestoneId}/request-release`  
**Status**: 501 - Needs Milestones SDK resource

---

### 🚧 Cancel Milestone Payment
**Python Example**: `examples/cancel_milestone_payment.py`  
**Endpoint**: `POST /freelancer/milestones/{milestoneId}/cancel`  
**Status**: 501 - Needs Milestones SDK resource

---

## Messages

### 🚧 Get Threads
**Python Example**: `examples/get_threads.py`  
**Endpoint**: `GET /freelancer/threads`  
**Status**: 501 - Needs Messages SDK resource

---

### 🚧 Get Messages
**Python Example**: `examples/get_messages.py`  
**Endpoint**: `GET /freelancer/messages`  
**Status**: 501 - Needs Messages SDK resource

---

### 🚧 Search Messages
**Python Example**: `examples/search_messages.py`  
**Endpoint**: `GET /freelancer/messages/search`  
**Status**: 501 - Needs Messages SDK resource

---

### 🚧 Create Message
**Python Example**: `examples/create_message.py`  
**Endpoint**: `POST /freelancer/messages`  
**Status**: 501 - Needs Messages SDK resource

```bash
# When implemented:
curl -X POST http://localhost:8000/freelancer/messages \
  -H "Content-Type: application/json" \
  -d '{
    "thread_id": 401,
    "message": "Hello, let'\''s discuss the project"
  }'
```

---

### 🚧 Create Message in Project Thread
**Python Example**: `examples/create_message_project_thread.py`  
**Endpoint**: `POST /freelancer/projects/{projectId}/messages`  
**Status**: 501 - Needs Messages SDK resource

---

### 🚧 Create Message with Attachment
**Python Example**: `examples/create_message_with_attachment.py`  
**Endpoint**: `POST /freelancer/messages/attachment`  
**Status**: 501 - Needs Messages SDK resource

---

## Reviews

### 🚧 Create Employer Review
**Python Example**: `examples/create_employer_review.py`  
**Endpoint**: `POST /freelancer/reviews/employer`  
**Status**: 501 - Needs Reviews SDK resource

---

### 🚧 Create Freelancer Review
**Python Example**: `examples/create_freelancer_review.py`  
**Endpoint**: `POST /freelancer/reviews/freelancer`  
**Status**: 501 - Needs Reviews SDK resource

---

## Contests

### 🚧 Create Contest
**Python Example**: `examples/create_contest.py`  
**Endpoint**: `POST /freelancer/contests`  
**Status**: 501 - Needs Contests SDK resource

---

## Job Categories

### 🚧 Get Jobs
**Python Example**: `examples/get_jobs.py`  
**Endpoint**: `GET /freelancer/jobs`  
**Status**: 501 - Needs Jobs SDK resource

```bash
# When implemented:
curl http://localhost:8000/freelancer/jobs
```

---

## Tracks

### 🚧 Create Track
**Python Example**: `examples/create_track.py`  
**Endpoint**: `POST /freelancer/tracks`  
**Status**: 501 - Needs Tracks SDK resource

---

### 🚧 Get Specific Track
**Python Example**: `examples/get_specific_track.py`  
**Endpoint**: `GET /freelancer/tracks/{trackId}`  
**Status**: 501 - Needs Tracks SDK resource

---

### 🚧 Update Track
**Python Example**: `examples/update_track.py`  
**Endpoint**: `PUT /freelancer/tracks/{trackId}`  
**Status**: 501 - Needs Tracks SDK resource

---

## Implementation Roadmap

To implement the stubbed endpoints, you'll need to:

1. **Create SDK Resources** in `packages/freelancer-sdk-php/src/Resources/`:
   - `Users/Users.php`
   - `Messages/Messages.php`
   - `Milestones/Milestones.php`
   - `Reviews/Reviews.php`
   - `Contests/Contests.php`
   - `Jobs/Jobs.php`
   - `Tracks/Tracks.php`

2. **Create Exception Classes** for each resource:
   - `UsersNotFoundException`
   - `MessagesNotFoundException`
   - `MilestonesNotFoundException`
   - etc.

3. **Update Service Provider** to bind new resources to DI container

4. **Implement Controller Methods** - replace `501` responses with actual SDK calls

5. **Add Validation** to controller methods

6. **Write Tests** for new endpoints

7. **Update Documentation** with actual examples

---

## Testing Stubbed Endpoints

All stubbed endpoints return:

```json
{
  "success": false,
  "message": "Not implemented - [ResourceName] SDK resource required"
}
```

HTTP Status: `501 Not Implemented`

Example:
```bash
curl http://localhost:8000/freelancer/users/self

# Response:
{
  "success": false,
  "message": "Not implemented - Users SDK resource required"
}
```

---

## Development Notes

- All controller methods follow the same pattern as implemented Projects/Bids methods
- Validation rules will need to be added based on API requirements
- Exception handling follows established patterns
- HTTP status codes: 404 for not found, 400 for bad requests, 422 for validation, 500 for server errors
- All methods use dependency injection for testability

---

## Related Files

- **Controller**: `laravel-app/app/Http/Controllers/FreelancerController.php`
- **Routes**: `laravel-app/routes/web.php`
- **Service Provider**: `laravel-app/app/Providers/FreelancerServiceProvider.php`
- **Python Examples**: `examples/` directory (reference implementation)
