<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Sauce",
 *     type="object",
 *     title="Sauce",
 *     description="Sauce model schema",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier for the sauce"),
 *     @OA\Property(property="name", type="string", description="Name of the sauce"),
 *     @OA\Property(property="pivot", type="object", description="Pivot table data",
 *         @OA\Property(property="kebab_id", type="integer", description="Kebab ID"),
 *         @OA\Property(property="sauce_type_id", type="integer", description="Sauce type ID")
 *     )
 * )
 */

class SauceSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}