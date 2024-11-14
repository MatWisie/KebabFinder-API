<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="SocialMedia",
 *     type="object",
 *     description="Social media link schema",
 *     @OA\Property(property="id", type="integer", description="Social media link ID"),
 *     @OA\Property(property="link", type="string", format="url", description="Social media URL")
 * )
 */

class SocialMediaSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}