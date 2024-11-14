<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="OpeningHour",
 *     type="object",
 *     description="Opening hours schema",
 *     @OA\Property(property="day", type="string", description="Day of the week"),
 *     @OA\Property(property="open", type="string", format="time", nullable=true, description="Opening time"),
 *     @OA\Property(property="close", type="string", format="time", nullable=true, description="Closing time")
 * )
 */

class OpeningHourSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}