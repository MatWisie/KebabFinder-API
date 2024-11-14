<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="OrderWay",
 *     type="object",
 *     description="Order way schema",
 *     @OA\Property(property="id", type="integer", description="Order way ID"),
 *     @OA\Property(property="app_name", type="string", nullable=true, description="App name for ordering"),
 *     @OA\Property(property="phone_number", type="string", nullable=true, description="Phone number for ordering"),
 *     @OA\Property(property="website", type="string", format="url", nullable=true, description="Website for ordering")
 * )
 */

class OrderWaySchemas
{
    // class is empty, as it's used only to store Swagger annotations
}