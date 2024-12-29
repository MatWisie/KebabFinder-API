<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Report",
 *     type="object",
 *     title="Report",
 *     description="Report model schema",
 *     required={"id", "kebab_id", "user_id", "content", "status"},
 *     
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the report",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="kebab_id",
 *         type="integer",
 *         description="ID of the kebab being reported",
 *         example=42
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="ID of the user who created the report",
 *         example=5
 *     ),
 *     @OA\Property(
 *         property="content",
 *         type="string",
 *         description="Content of the report",
 *         example="Kebab seems to have different opening hours than stated."
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="Current status of the report",
 *         enum={"Waiting", "Accepted", "Refused"},
 *         example="Waiting"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Record creation timestamp",
 *         example="2024-12-22T10:55:13.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Record last update timestamp",
 *         example="2024-12-22T11:11:45.000000Z"
 *     )
 * )
 */
class ReportSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}
