<?php

namespace FreelancerSdk\Resources\Projects;

/**
 * Helper functions for creating project-related objects.
 */
class Helpers
{
    /**
     * Builds an associative array representing a currency.
     *
     * @param int $id The currency identifier.
     * @param string|null $code The ISO code of the currency (e.g., "USD"), or null to omit.
     * @param string|null $sign The currency sign/symbol (e.g., "$"), or null to omit.
     * @param string|null $name The human-readable currency name, or null to omit.
     * @param float|null $exchangeRate The exchange rate relative to a base currency, or null to omit.
     * @param string|null $country The country associated with the currency, or null to omit.
     * @return array An associative array containing 'id' and optionally 'code', 'sign', 'name', 'exchange_rate', and 'country'.
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
     * Build an associative array representing a job.
     *
     * @param int $id Job identifier.
     * @param string|null $name Human-readable job name.
     * @param array|null $category Category data for the job.
     * @param int|null $activeProjectCount Number of active projects in this job.
     * @param string|null $seoUrl SEO-friendly URL for the job.
     * @param array|null $seoInfo Additional SEO metadata.
     * @return array Associative array containing 'id' and, when provided, 'name', 'category', 'active_project_count', 'seo_url', and 'seo_info'.
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
     * Builds an associative array representing a budget with optional fields.
     *
     * @param float      $minimum     The minimum budget amount.
     * @param float|null $maximum     The maximum budget amount, if specified.
     * @param string|null $name       Human-readable name for the budget, if specified.
     * @param string|null $projectType The project type (for example `fixed` or `hourly`), if specified.
     * @param int|null   $currencyId  Identifier of the currency associated with the budget, if specified.
     * @return array Associative array containing the `minimum` key and, when provided, `maximum`, `name`, `project_type`, and `currency_id` keys.
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
     * Build hourly project commitment information.
     *
     * @param int $commitmentHours Number of committed hours.
     * @param string $commitmentInterval Commitment interval (for example, "week" or "month").
     * @return array Array with a 'commitment' key containing 'hours' (int) and 'interval' (string).
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
     * Builds an associative array representing a location.
     *
     * @param array|null  $country            Optional country info to include under the `country` key (e.g., id, code, name).
     * @param string|null $city               Optional city name to include under the `city` key.
     * @param float|null  $latitude           Optional latitude to include under the `latitude` key.
     * @param float|null  $longitude          Optional longitude to include under the `longitude` key.
     * @param string|null $vicinity           Optional vicinity/area description to include under the `vicinity` key.
     * @param string|null $administrativeArea Optional administrative area (state/region) to include under the `administrative_area` key.
     * @param string|null $fullAddress        Optional full postal address to include under the `full_address` key.
     * @return array Associative array containing any of the keys `country`, `city`, `latitude`, `longitude`, `vicinity`, `administrative_area`, and `full_address` for which arguments were provided.
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
     * Builds an associative array representing a bid.
     *
     * @param int $id The bid identifier.
     * @param int $bidderId The identifier of the user who placed the bid.
     * @param int $projectId The identifier of the project the bid targets.
     * @param bool $retracted `true` if the bid has been retracted, `false` otherwise.
     * @param float $amount The monetary amount offered in the bid.
     * @param int $period The proposed period/duration associated with the bid.
     * @param string $description The bidder's textual description or message.
     * @param int $projectOwnerId The identifier of the project owner.
     * @return array An associative array with keys: 'id', 'bidder_id', 'project_id', 'retracted', 'amount', 'period', 'description', 'project_owner_id'.
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
