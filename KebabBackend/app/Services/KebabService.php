<?php

namespace App\Services;

use App\Models\Kebab;
use App\Models\KebabSocialMedia;
use App\Models\OpeningHour;
use App\Models\OrderWay;

class KebabService
{
    public function getKebabData(array $validated): array
    {
        return [
            'name' => $validated['name'],
            'address' => $validated['address'],
            'coordinates' => $validated['coordinates'],
            'logo_link' => $validated['logo_link'] ?? null,
            'open_year' => $validated['open_year'] ?? null,
            'closed_year' => $validated['closed_year'] ?? null,
            'status' => $validated['status'],
            'pyszne_pl_link' => $validated['pyszne_pl_link'],
            'glovo_link' => $validated['glovo_link'],
            'is_craft' => $validated['is_craft'],
            'building_type' => $validated['building_type'],
            'is_chain' => $validated['is_chain'],
        ];
    }

    public function syncRelations(Kebab $kebab, array $validated): void
    {
        if (array_key_exists('sauces', $validated)) {
            $kebab->sauces()->sync($validated['sauces']);
        }

        if (array_key_exists('meats', $validated)) {
            $kebab->meatTypes()->sync($validated['meats']);
        }

        if (array_key_exists('social_media_links', $validated)) {
            $this->syncSocialMediaLinks($kebab, $validated['social_media_links']);
        }

        if (array_key_exists('opening_hours', $validated)) {
            $this->syncOpeningHours($kebab, $validated['opening_hours']);
        }

        if (array_key_exists('order_ways', $validated)) {
            $this->syncOrderWays($kebab, $validated['order_ways']);
        }
    }

    private function syncSocialMediaLinks(Kebab $kebab, array $links): void
    {
        $kebab->socialMedias()->delete();
        foreach ($links as $link) {
            KebabSocialMedia::create([
                'kebab_id' => $kebab->id,
                'social_media_link' => $link
            ]);
        }
    }

    private function syncOpeningHours(Kebab $kebab, array $openingHoursData): void
    {
        $openingHours = $kebab->openingHour ?: new OpeningHour(['kebab_id' => $kebab->id]);

        foreach ($openingHoursData as $day => $hours) {
            $openingHours->{$day . '_open'} = $hours['open'] ?? null;
            $openingHours->{$day . '_close'} = $hours['close'] ?? null;
        }

        $openingHours->save();
    }

    private function syncOrderWays(Kebab $kebab, array $orderWays): void
    {
        $kebab->orderWay()->delete();
        foreach ($orderWays as $way) {
            OrderWay::create([
                'kebab_id' => $kebab->id,
                'app_name' => $way['app_name'] ?? null,
                'phone_number' => $way['phone_number'] ?? null,
                'website' => $way['website'] ?? null,
            ]);
        }
    }
}
