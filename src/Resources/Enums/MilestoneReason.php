<?php

namespace FreelancerSdk\Resources\Enums;

/**
 * Milestone reason enumeration
 */
enum MilestoneReason: int
{
    case FULL_PAYMENT = 0;
    case PARTIAL_PAYMENT = 1;
    case TASK_DESCRIPTION = 2;
    case OTHER = 3;
}