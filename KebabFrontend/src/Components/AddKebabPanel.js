import React, { useEffect, useState } from "react";

export default function AddKebabPanel({coordinates, onAction}) {
    const apiUrl = process.env.REACT_APP_API_URL
    const [sauces, setSauces] = useState([])
    const [meatTypes, setMeatTypes] = useState([])
    const [addingKebab, setAddingKebab] = useState(false)
    const [formData, setFormData] = useState({
        name: "Kebab",
        address: "Kebab City, Kebab Street 68",
        coordinates: coordinates,
        open_year: 0,
        closed_year: 0,
        status: "",
        is_craft: false,
        is_chain: false,
        building_type: "",
        sauces: '',
        meat_types: '',
        opening_hours: {},
      });

    async function handleSubmit(event) {
        event.preventDefault()
        console.log(formData)
        setAddingKebab(true)
        try {
            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content': 'application/json'
                }                
            })

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText)
            }
            
        } catch (error) {
            console.log(error)
            
        } finally {
            setAddingKebab(false)
        }
    }

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

    async function getSauces() {
        try {
            var response = await fetch(apiUrl + 'saucetypes', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content': 'application/json'
                }
            })

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText)
            }
            var data = await response.json()
            console.log(data)
            
        } catch (error) {
            console.log(error)
        }
    }

    async function getMeatTypes() {
        try {
            var response = await fetch(apiUrl + 'meattypes', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content': 'application/json'
                }
            })

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText)
            }
            var data = await response.json()
            console.log(data)
            
        } catch (error) {
            console.log(error)
        }
    }

    useEffect(()=>{
        getSauces()
        getMeatTypes()
    }, [])

    return (
        <div id='add-kebab-panel' className="right-0 fixed flex justify-center items-center bg-gray-500 z-50 w-full h-full bg-opacity-70">
            <div className="bg-white p-6 sm:rounded-lg shadow-lg relative sm:h-3/4 sm:w-3/4 w-full h-full overflow-y-auto ">
                <button onClick={onAction} className="text-xl absolute top-2 right-2 text-gray-600 hover:text-gray-800">
                    X
                </button>
                <h1 className="text-2xl">Add a new Kebab</h1>
                <form className="w-2/3 mx-auto" onSubmit={handleSubmit}>
                    <div>
                    <label className="block text-gray-700 font-medium m-2">Name</label>
                    <input
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        placeholder="Enter name"
                        className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                        required
                    />
                    </div>
                    <div>
                    <label className="block text-gray-700 font-medium m-2 p-1">Address</label>
                    <input
                        type="text"
                        name="address"
                        value={formData.address}
                        onChange={handleChange}
                        placeholder="Enter address"
                        className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                        required
                    />
                    </div>
                    <div>
                    <label className="block text-gray-700 font-medium m-2">Coordinates</label>
                    <input
                        type="text"
                        name="coordinates"
                        value={formData.coordinates}
                        onChange={handleChange}
                        placeholder="Enter coordinates"
                        className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                        required
                    />
                    </div>
                    <div>
                    <label className="block text-gray-700 font-medium m-2">Opened Year</label>
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
                    <label className="block text-gray-700 font-medium m-2">Closed Year</label>
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
                    <label className="block text-gray-700 font-medium m-2" htmlFor="status">Status</label>
                    <select 
                        id="status" 
                        name="status"
                        value={formData.status}
                        onChange={handleChange}
                        className="p-2 m-2 rounded-lg"
                        required
                    >
                        <option value="">Select Status</option>
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                        <option value="planned">Plannned</option>
                    </select>
                    </div>
                    <div className="flex items-center justify-center space-x-2">
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
                    <label className="block text-gray-700 font-medium m-2">Building Type</label>
                    <input
                        type="text"
                        name="building_type"
                        value={formData.building_type}
                        onChange={handleChange}
                        placeholder="Enter building type"
                        className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                        required
                    />
                    </div>
                    <div>
                    <label className="block text-gray-700 font-medium m-2">Sauces</label>
                    <input
                        type="text"
                        name="sauces"
                        value={formData.sauces}
                        onChange={handleChange}
                        placeholder="Enter sauces (comma-separated)"
                        className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                        required
                    />
                    </div>
                    <div>
                    <label className="block text-gray-700 font-medium m-2">Meat Types</label>
                    {meatTypes.map((meatType, index) => (
                        <input 
                            key={index} 
                            type="check" 
                            value={meatType.name}
                        />
                    ))}
                    <input
                        type="text"
                        name="meat_types"
                        value={formData.meat_types}
                        onChange={handleChange}
                        placeholder="Enter meat types (comma-separated)"
                        className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                        required
                    />
                    </div>
                    <div>
                <label className="block text-gray-700 font-medium m-2">Opening Hours</label>
                <div className="space-y-4">
                    {["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"].map((day) => (
                        <div key={day} className="flex items-center gap-4">
                            <h2 className="text-center text-lg font-medium text-gray-700 w-full">
                                {day.charAt(0).toUpperCase() + day.slice(1)}
                            </h2>
                            <label className="w-1/4 text-gray-500 text-sm">
                                Opens
                            </label>
                            <input
                                type="time"
                                value={formData.opening_hours[`${day}_open`] || ""}
                                onChange={(e) => handleNestedChange(day, "open", e.target.value)}
                                className="w-1/4 px-2 py-1 border rounded-md"
                            />
                            <label className="w-1/4 text-gray-500 text-sm">
                                Closes
                            </label>
                            <input
                                type="time"
                                value={formData.opening_hours[`${day}_close`] || ""}
                                onChange={(e) => handleNestedChange(day, "close", e.target.value)}
                                className="w-1/4 px-2 py-1 border rounded-md"
                            />
                        </div>
                    ))}
                </div>
            </div>
            <button
                type="submit"
                disabled={addingKebab}
                className="w-full px-4 py-2 mt-4 mb-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-indigo-300"
            >
                {addingKebab ? 'Loading...' : 'Add Kebab'}
            </button>
                </form>
            </div>
        </div>
    )
}