import React from "react";
import EditRestaurantForm from "./EditKebabPanel";

export default function AdminPanel(){
    var restaurant = {
      "id": 1,
      "name": "Sample Kebab Place",
      "address": "123 Kebab St, Kebab City",
      "coordinates": "51.5074, -10.1278",
      "logo_link": "http://example.com",
      "open_year": 1999,
      "closed_year": 2020,
      "status": "open",
      "is_craft": 1,
      "building_type": "domek",
      "is_chain": 1,
      "google_review": null,
      "pyszne_pl_review": null,
      "created_at": "2024-11-28T15:56:49.000000Z",
      "updated_at": "2024-11-28T15:56:49.000000Z",
      "sauces": [
        {
          "id": 1,
          "name": "Ketchup",
          "pivot": {
            "kebab_id": 1,
            "sauce_type_id": 1
          }
        },
        {
          "id": 2,
          "name": "Mayonnaise",
          "pivot": {
            "kebab_id": 1,
            "sauce_type_id": 2
          }
        }
      ],
      "meat_types": [
        {
          "id": 2,
          "name": "Beef",
          "pivot": {
            "kebab_id": 1,
            "meat_type_id": 2
          }
        },
        {
          "id": 4,
          "name": "Mixed",
          "pivot": {
            "kebab_id": 1,
            "meat_type_id": 4
          }
        }
      ],
      "social_medias": [],
      "opening_hour": {
        "id": 1,
        "kebab_id": 1,
        "monday_open": "10:00",
        "monday_close": "22:00",
        "tuesday_open": "10:00",
        "tuesday_close": "22:00",
        "wednesday_open": "10:00",
        "wednesday_close": "22:00",
        "thursday_open": "10:00",
        "thursday_close": "22:00",
        "friday_open": "10:00",
        "friday_close": "23:00",
        "saturday_open": null,
        "saturday_close": null,
        "sunday_open": null,
        "sunday_close": null,
        "created_at": "2024-11-28T15:56:50.000000Z",
        "updated_at": "2024-11-28T15:56:50.000000Z"
      },
      "order_way": []
    }
    return (
        <div>
            This is the admin panel
            There will be a map here
            <EditRestaurantForm restaurant={restaurant} />
        </div>
    )
}