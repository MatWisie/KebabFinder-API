<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Kebab",
 *     type="object",
 *     title="Kebab",
 *     description="Kebab model schema",
 *     required={"id", "name", "address"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier for the kebab"),
 *     @OA\Property(property="name", type="string", description="Name of the kebab place"),
 *     @OA\Property(property="address", type="string", description="Address of the kebab place"),
 *     @OA\Property(property="coordinates", type="string", description="Coordinates of the kebab place"),
 *     @OA\Property(property="google_review", type="number", format="float", nullable=true, description="Google review rating"),
 *     @OA\Property(property="pyszne_pl_review", type="number", format="float", nullable=true, description="Pyszne.pl review rating"),
 *     @OA\Property(property="sauces", type="array", @OA\Items(ref="#/components/schemas/Sauce")),
 *     @OA\Property(property="meatTypes", type="array", @OA\Items(ref="#/components/schemas/MeatType")),
 *     @OA\Property(property="socialMedias", type="array", @OA\Items(ref="#/components/schemas/SocialMedia")),
 *     @OA\Property(property="openingHours", type="array", @OA\Items(ref="#/components/schemas/OpeningHour")),
 *     @OA\Property(property="orderWay", type="array", @OA\Items(ref="#/components/schemas/OrderWay"))
 * )
 */

class KebabSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}