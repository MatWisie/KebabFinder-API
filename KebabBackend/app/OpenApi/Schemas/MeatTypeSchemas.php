<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="MeatType",
 *     type="object",
 *     description="Meat type schema",
 *     @OA\Property(property="id", type="integer", description="Meat type ID"),
 *     @OA\Property(property="name", type="string", description="Meat type name")
 * )
 */

class MeatTypeSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}