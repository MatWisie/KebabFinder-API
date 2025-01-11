<?php

namespace App\OpenApi\Schemas;


/**
 * @OA\Schema(
 *     schema="Kebab",
 *     type="object",
 *     title="Kebab",
 *     description="Kebab model schema",
 *     required={"id", "name", "address", "status", "is_craft", "building_type", "is_chain"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier for the kebab"),
 *     @OA\Property(property="name", type="string", description="Name of the kebab place"),
 *     @OA\Property(property="address", type="string", description="Address of the kebab place"),
 *     @OA\Property(property="coordinates", type="string", description="Coordinates of the kebab place"),
 *     @OA\Property(property="logo_link", type="string", nullable=true, description="URL to kebab logo"),
 *     @OA\Property(property="open_year", type="integer", nullable=true, description="Year when the kebab opened"),
 *     @OA\Property(property="closed_year", type="integer", nullable=true, description="Year when the kebab closed"),
 *     @OA\Property(property="status", type="string", enum={"open", "closed", "under renovation"}, description="Current status of the kebab place"),
 *     @OA\Property(property="pyszne_pl_link", type="string", description="Link to pyszne.pl for rating"),
 *     @OA\Property(property="is_craft", type="boolean", description="Indicates if the kebab is a craft kebab"),
 *     @OA\Property(property="building_type", type="string", description="Type of building the kebab operates in"),
 *     @OA\Property(property="is_chain", type="boolean", description="Indicates if the kebab place is part of a chain"),
 *     @OA\Property(property="google_review", type="number", format="float", nullable=true, description="Google review rating"),
 *     @OA\Property(property="pyszne_pl_review", type="number", format="float", nullable=true, description="Pyszne.pl review rating"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Record creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Record last update timestamp"),
 *     @OA\Property(
 *         property="sauces",
 *         type="array",
 *         description="List of available sauces",
 *         @OA\Items(ref="#/components/schemas/Sauce")
 *     ),
 *     @OA\Property(
 *         property="meat_types",
 *         type="array",
 *         description="List of available meat types",
 *         @OA\Items(ref="#/components/schemas/MeatType")
 *     ),
 *     @OA\Property(
 *         property="social_medias",
 *         type="array",
 *         description="List of social media links",
 *         @OA\Items(ref="#/components/schemas/SocialMedia")
 *     ),
 *     @OA\Property(
 *         property="opening_hour",
 *         ref="#/components/schemas/OpeningHour"
 *     ),
 *     @OA\Property(
 *         property="order_way",
 *         type="array",
 *         description="Available ordering methods",
 *         @OA\Items(ref="#/components/schemas/OrderWay")
 *     )
 * )
 */

class KebabSchemas
{
    // class is empty, as it's used only to store Swagger annotations
}