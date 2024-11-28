<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="MeatType",
 *     type="object",
 *     title="Meat Type",
 *     description="Meat Type model schema",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier for the meat type"),
 *     @OA\Property(property="name", type="string", description="Name of the meat type"),
 *     @OA\Property(property="pivot", type="object", description="Pivot table data",
 *         @OA\Property(property="kebab_id", type="integer", description="Kebab ID"),
 *         @OA\Property(property="meat_type_id", type="integer", description="Meat type ID")
 *     )
 * )
 */

class MeatTypeSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}