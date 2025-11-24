<?php

namespace FreelancerSdk\Resources\Projects;

/**
 * Helper functions for creating project-related objects.
 */
class Helpers
{
    /**
     * Create a currency object.
     */
    public static function createCurrencyObject(
        int $id,
        ?string $code = null,
        ?string $sign = null,
        ?string $name = null,
        ?float $exchangeRate = null,
        ?string $country = null
    ): array {
        $currency = ['id' => $id];

        if ($code !== null) {
            $currency['code'] = $code;
        }
        if ($sign !== null) {
            $currency['sign'] = $sign;
        }
        if ($name !== null) {
            $currency['name'] = $name;
        }
        if ($exchangeRate !== null) {
            $currency['exchange_rate'] = $exchangeRate;
        }
        if ($country !== null) {
            $currency['country'] = $country;
        }

        return $currency;
    }

    /**
     * Create a job object.
     */
    public static function createJobObject(
        int $id,
        ?string $name = null,
        ?array $category = null,
        ?int $activeProjectCount = null,
        ?string $seoUrl = null,
        ?array $seoInfo = null
    ): array {
        $job = ['id' => $id];

        if ($name !== null) {
            $job['name'] = $name;
        }
        if ($category !== null) {
            $job['category'] = $category;
        }
        if ($activeProjectCount !== null) {
            $job['active_project_count'] = $activeProjectCount;
        }
        if ($seoUrl !== null) {
            $job['seo_url'] = $seoUrl;
        }
        if ($seoInfo !== null) {
            $job['seo_info'] = $seoInfo;
        }

        return $job;
    }

    /**
     * Create a budget object.
     */
    public static function createBudgetObject(
        float $minimum,
        ?float $maximum = null,
        ?string $name = null,
        ?string $projectType = null,
        ?int $currencyId = null
    ): array {
        $budget = ['minimum' => $minimum];

        if ($maximum !== null) {
            $budget['maximum'] = $maximum;
        }
        if ($name !== null) {
            $budget['name'] = $name;
        }
        if ($projectType !== null) {
            $budget['project_type'] = $projectType;
        }
        if ($currencyId !== null) {
            $budget['currency_id'] = $currencyId;
        }

        return $budget;
    }

    /**
     * Create an hourly project info object.
     */
    public static function createHourlyProjectInfoObject(
        int $commitmentHours,
        string $commitmentInterval
    ): array {
        return [
            'commitment' => [
                'hours'    => $commitmentHours,
                'interval' => $commitmentInterval,
            ],
        ];
    }

    /**
     * Create a location object.
     */
    public static function createLocationObject(
        ?array $country = null,
        ?string $city = null,
        ?float $latitude = null,
        ?float $longitude = null,
        ?string $vicinity = null,
        ?string $administrativeArea = null,
        ?string $fullAddress = null
    ): array {
        $location = [];

        if ($country !== null) {
            $location['country'] = $country;
        }
        if ($city !== null) {
            $location['city'] = $city;
        }
        if ($latitude !== null) {
            $location['latitude'] = $latitude;
        }
        if ($longitude !== null) {
            $location['longitude'] = $longitude;
        }
        if ($vicinity !== null) {
            $location['vicinity'] = $vicinity;
        }
        if ($administrativeArea !== null) {
            $location['administrative_area'] = $administrativeArea;
        }
        if ($fullAddress !== null) {
            $location['full_address'] = $fullAddress;
        }

        return $location;
    }

    /**
     * Create a bid object.
     */
    public static function createBidObject(
        int $id,
        int $bidderId,
        int $projectId,
        bool $retracted,
        float $amount,
        int $period,
        string $description,
        int $projectOwnerId
    ): array {
        return [
            'id'               => $id,
            'bidder_id'        => $bidderId,
            'project_id'       => $projectId,
            'retracted'        => $retracted,
            'amount'           => $amount,
            'period'           => $period,
            'description'      => $description,
            'project_owner_id' => $projectOwnerId,
        ];
    }
}
