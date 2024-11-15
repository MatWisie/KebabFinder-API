<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="OpeningHour",
 *     type="object",
 *     title="Opening Hour",
 *     description="Opening Hour model schema",
 *     required={"id", "kebab_id"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier for the opening hour"),
 *     @OA\Property(property="kebab_id", type="integer", description="Kebab ID"),
 *     @OA\Property(property="monday_open", type="string", format="time", description="Opening time on Monday"),
 *     @OA\Property(property="monday_close", type="string", format="time", description="Closing time on Monday"),
 *     @OA\Property(property="tuesday_open", type="string", format="time", description="Opening time on Tuesday"),
 *     @OA\Property(property="tuesday_close", type="string", format="time", description="Closing time on Tuesday"),
 *     @OA\Property(property="wednesday_open", type="string", format="time", description="Opening time on Wednesday"),
 *     @OA\Property(property="wednesday_close", type="string", format="time", description="Closing time on Wednesday"),
 *     @OA\Property(property="thursday_open", type="string", format="time", description="Opening time on Thursday"),
 *     @OA\Property(property="thursday_close", type="string", format="time", description="Closing time on Thursday"),
 *     @OA\Property(property="friday_open", type="string", format="time", description="Opening time on Friday"),
 *     @OA\Property(property="friday_close", type="string", format="time", description="Closing time on Friday"),
 *     @OA\Property(property="saturday_open", type="string", format="time", description="Opening time on Saturday"),
 *     @OA\Property(property="saturday_close", type="string", format="time", description="Closing time on Saturday"),
 *     @OA\Property(property="sunday_open", type="string", format="time", description="Opening time on Sunday"),
 *     @OA\Property(property="sunday_close", type="string", format="time", description="Closing time on Sunday"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Record creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Record last update timestamp")
 * )
 */

class OpeningHourSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}