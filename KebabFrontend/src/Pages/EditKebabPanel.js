// import React from "react";

// export default function EditKebabPanel(kebab){
//     // return(
//     //     <div id="edit-kebab-panel">
//     //         <h1>Edit Kebab Panel</h1>
//     //         <form className="flex flex-col">
//     //             <input placeholder="Name"></input>
//     //             <input placeholder="Address"></input>
//     //             <input placeholder="Coordinates"></input>
//     //             <input placeholder="OpenedYear"></input>
//     //             <input placeholder="ClosedYear"></input>
//     //             <input placeholder="Status"></input>
//     //             <input placeholder="IsCraft" type="check"></input>
//     //             <input placeholder="BuildingType"></input>
//     //             <input placeholder="IsChain"></input>
//     //             <input placeholder="Sauces"></input>
//     //             <input placeholder="MeatTypes"></input>
//     //             <input placeholder="SocialMedia"></input>
//     //             <input placeholder="OpeningHours"></input>
//     //             <input placeholder="WaysToOrder"></input>
//     //         </form>
            
//     //     </div>
//     // )
//     return (
//         <div className="max-w-md mx-auto p-6 bg-white shadow-lg rounded-md">
//           <h1 className="text-2xl font-semibold text-center mb-4">Edit Kebab</h1>
//           <form className="flex flex-col space-y-4">
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Name</label>
//               <input
//                 type="text"
//                 placeholder="Enter name"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Address</label>
//               <input
//                 type="text"
//                 placeholder="Enter address"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Coordinates</label>
//               <input
//                 type="text"
//                 placeholder="Enter coordinates"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Opened Year</label>
//               <input
//                 type="number"
//                 placeholder="Enter opened year"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Closed Year</label>
//               <input
//                 type="number"
//                 placeholder="Enter closed year"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Status</label>
//               <input
//                 type="text"
//                 placeholder="Enter status"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div className="flex items-center space-x-2">
//               <input
//                 type="checkbox"
//                 id="isCraft"
//                 className="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring focus:ring-indigo-300"
//               />
//               <label htmlFor="isCraft" className="text-gray-700 font-medium">
//                 Is Craft
//               </label>
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Building Type</label>
//               <input
//                 type="text"
//                 placeholder="Enter building type"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Is Chain</label>
//               <input
//                 type="text"
//                 placeholder="Enter chain status"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Sauces</label>
//               <input
//                 type="text"
//                 placeholder="Enter sauces"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Meat Types</label>
//               <input
//                 type="text"
//                 placeholder="Enter meat types"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Social Media</label>
//               <input
//                 type="text"
//                 placeholder="Enter social media links"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Opening Hours</label>
//               <input
//                 type="text"
//                 placeholder="Enter opening hours"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <div>
//               <label className="block text-gray-700 font-medium mb-1">Ways to Order</label>
//               <input
//                 type="text"
//                 placeholder="Enter ways to order"
//                 className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
//               />
//             </div>
//             <button
//               type="submit"
//               className="w-full px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-300"
//             >
//               Submit
//             </button>
//           </form>
//         </div>
//       )
// }
import React, { useState } from "react";

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



const EditRestaurantForm = ({ restaurant }) => {
  const [formData, setFormData] = useState({
    name: restaurant.name || "",
    address: restaurant.address || "",
    coordinates: restaurant.coordinates || "",
    open_year: restaurant.open_year || "",
    closed_year: restaurant.closed_year || "",
    status: restaurant.status || "",
    is_craft: restaurant.is_craft === 1,
    building_type: restaurant.building_type || "",
    is_chain: restaurant.is_chain === 1,
    sauces: restaurant.sauces.map((sauce) => sauce.name).join(", "),
    meat_types: restaurant.meat_types.map((meat) => meat.name).join(", "),
    opening_hours: restaurant.opening_hour || {},
  });

  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData({
      ...formData,
      [name]: type === "checkbox" ? checked : value,
    });
  };

  const handleNestedChange = (day, field, value) => {
    setFormData((prevState) => ({
      ...prevState,
      opening_hours: {
        ...prevState.opening_hours,
        [`${day}_${field}`]: value,
      },
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Updated Data:", formData);
    // Submit the formData to the API
  };

  return (
    <div className="max-w-md mx-auto p-6 bg-white shadow-lg rounded-md">
      <h1 className="text-2xl font-semibold text-center mb-4">Edit Restaurant</h1>
      <form className="flex flex-col space-y-4" onSubmit={handleSubmit}>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Name</label>
          <input
            type="text"
            name="name"
            value={formData.name}
            onChange={handleChange}
            placeholder="Enter name"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Address</label>
          <input
            type="text"
            name="address"
            value={formData.address}
            onChange={handleChange}
            placeholder="Enter address"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Coordinates</label>
          <input
            type="text"
            name="coordinates"
            value={formData.coordinates}
            onChange={handleChange}
            placeholder="Enter coordinates"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Opened Year</label>
          <input
            type="number"
            name="open_year"
            value={formData.open_year}
            onChange={handleChange}
            placeholder="Enter opened year"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Closed Year</label>
          <input
            type="number"
            name="closed_year"
            value={formData.closed_year}
            onChange={handleChange}
            placeholder="Enter closed year"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Status</label>
          <input
            type="text"
            name="status"
            value={formData.status}
            onChange={handleChange}
            placeholder="Enter status"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div className="flex items-center space-x-2">
          <input
            type="checkbox"
            name="is_craft"
            checked={formData.is_craft}
            onChange={handleChange}
            className="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring focus:ring-indigo-300"
          />
          <label htmlFor="is_craft" className="text-gray-700 font-medium">
            Is Craft
          </label>
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Building Type</label>
          <input
            type="text"
            name="building_type"
            value={formData.building_type}
            onChange={handleChange}
            placeholder="Enter building type"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Sauces</label>
          <input
            type="text"
            name="sauces"
            value={formData.sauces}
            onChange={handleChange}
            placeholder="Enter sauces (comma-separated)"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Meat Types</label>
          <input
            type="text"
            name="meat_types"
            value={formData.meat_types}
            onChange={handleChange}
            placeholder="Enter meat types (comma-separated)"
            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
          />
        </div>
        <div>
          <label className="block text-gray-700 font-medium mb-1">Opening Hours</label>
          <div className="grid grid-cols-2 gap-4">
            {["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"].map((day) => (
              <div key={day}>
                <label className="block text-gray-500 text-sm">
                  {day.charAt(0).toUpperCase() + day.slice(1)} Open
                </label>
                <input
                  type="time"
                  value={formData.opening_hours[`${day}_open`] || ""}
                  onChange={(e) => handleNestedChange(day, "open", e.target.value)}
                  className="w-full px-2 py-1 border rounded-md"
                />
                <label className="block text-gray-500 text-sm mt-1">Close</label>
                <input
                  type="time"
                  value={formData.opening_hours[`${day}_close`] || ""}
                  onChange={(e) => handleNestedChange(day, "close", e.target.value)}
                  className="w-full px-2 py-1 border rounded-md"
                />
              </div>
            ))}
          </div>
        </div>
        <button
          type="submit"
          className="w-full px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring focus:ring-indigo-300"
        >
          Save Changes
        </button>
      </form>
    </div>
  );
};

export default EditRestaurantForm;
