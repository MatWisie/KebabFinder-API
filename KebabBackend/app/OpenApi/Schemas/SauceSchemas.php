<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Sauce",
 *     type="object",
 *     description="Sauce type schema",
 *     @OA\Property(property="id", type="integer", description="Sauce ID"),
 *     @OA\Property(property="name", type="string", description="Sauce name")
 * )
 */

class SauceSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}