import React, { useContext, useEffect, useState } from "react";
import { UserContext } from "../Contexts/AuthContext";

export default function EditKebabPanel({kebab, onAction, onKebabEdited}) {
    const apiUrl = process.env.REACT_APP_API_URL
    const {token} = useContext(UserContext)
    const [sauces, setSauces] = useState([])
    const [meatTypes, setMeatTypes] = useState([])
    const [addingKebab, setAddingKebab] = useState(false)
    const [errorMessage, setErrorMessage] = useState('')

    const [formData, setFormData] = useState(kebab)
    // const [formData, setFormData] = useState({
    //     name: "Kebab",
    //     address: "Kebab City, Kebab Street 68",
    //     logolink: "https://example.com",
    //     coordinates: coordinates,
    //     open_year: 1990,
    //     closed_year: 2000,
    //     status: "open",
    //     is_craft: false,
    //     is_chain: false,
    //     building_type: "domek",
    //     sauces: [],
    //     meats: [],
    //     social_media_links: [],
    //     opening_hours: {
    //         monday: {
    //             open: '08:00',
    //             close: '20:00'
    //         },
    //         tuesday: {
    //             open: '08:00',
    //             close: '20:00'
    //         },
    //         wednesday: {
    //             open: '08:00',
    //             close: '20:00'
    //         },
    //         thursday: {
    //             open: '08:00',
    //             close: '20:00'
    //         },
    //         friday: {
    //             open: '08:00',
    //             close: '20:00'
    //         },
    //         saturday: {
    //             open: '08:00',
    //             close: '20:00'
    //         },
    //         sunday: {
    //             open: '08:00',
    //             close: '20:00'
    //         },
            
    //     },
    //     order_ways: []
    //   });
      

    async function handleSubmit(event) {
        setErrorMessage('')
        event.preventDefault()
        console.log(formData)
        setAddingKebab(true)
        try {
            const response = await fetch(apiUrl + 'kebabs', {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(formData)               
            })

            if (!response.ok) {
                if(response.status == 422) {
                    setErrorMessage('Wrong data entered')
                } else {
                    setErrorMessage('An error has occured - '+ response.statusText)
                }
                
                throw new Error('Network response was not ok ' + response.statusText)
            }

            onKebabEdited()
            
        } catch (error) {
            //setErrorMessage('An error has occured. ' + error)
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
    
      const handleOpeningHoursChange = (day, field, value) => {
        setFormData((prevState) => ({
            ...prevState,
            opening_hours: {
                ...prevState.opening_hours,
                [day]: {
                    ...prevState.opening_hours[day],
                    [field]: value,
                },
            },
        }));
    };

    const handleSaucesChange = (sauceId) => {
        setFormData((prevState) => {
            const { sauces, ...otherData } = prevState;
            const newSauces = sauces.includes(sauceId)
                ? sauces.filter(id => id !== sauceId)
                : [...sauces, sauceId]
    
            return {
                ...otherData,
                sauces: newSauces,
            };
        });
    };    

    const handleMeatTypesChange = (meatId) => {
        setFormData((prevState) => {
            const { meats, ...otherData } = prevState;
            const newMeatTypes = meats.includes(meatId)
                ? meats.filter(id => id !== meatId)
                : [...meats, meatId];
    
            return {
                ...otherData,
                meats: newMeatTypes,
            };
        });
    };

    const handleOrderWaysChange = (index, field, value) => {
        setFormData((prevState) => {
            const updatedOrderWays = [...prevState.order_ways];
            updatedOrderWays[index] = {
                ...updatedOrderWays[index],
                [field]: value,
            };
            return {
                ...prevState,
                order_ways: updatedOrderWays,
            };
        });
    };

    const handleSocialMediaLinksChange = (index, value) => {
        setFormData((prevState) => {
            const updatedSocialMediaLinks = [...prevState.social_media_links];
            updatedSocialMediaLinks[index] = value; // Update the specific index with the new value
            return {
                ...prevState,
                social_media_links: updatedSocialMediaLinks,
            };
        });
    };

    const handleRemoveSocialMediaLink = (index) => {
        setFormData((prevState) => {
            const updatedSocialMediaLinks = prevState.social_media_links.filter((_, i) => i !== index);
            return {
                ...prevState,
                social_media_links: updatedSocialMediaLinks,
            };
        });
    };

    const handleRemoveOrderWay = (index) => {
        setFormData((prevState) => {
            const updatedOrderWays = prevState.order_ways.filter((_, i) => i !== index);
            return {
                ...prevState,
                order_ways: updatedOrderWays,
            };
        });
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
            setSauces(data)
            
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
            setMeatTypes(data)
            
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
            <div className="bg-white p-6 sm:rounded-lg shadow-lg relative sm:h-3/4 sm:w-3/4 w-full h-full overflow-y-auto relative">
                <button onClick={onAction} className="text-xl top-2 right-2 text-gray-600 hover:text-gray-800 sticky w-full text-right">
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
                        <label className="block text-gray-700 font-medium m-2 p-1">Logo Link</label>
                        <input
                            type="url"
                            name="logolink"
                            value={formData.logolink}
                            onChange={handleChange}
                            placeholder="Enter logolink"
                            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                            
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
                        <label htmlFor="is_chain" className="text-gray-700 font-medium">
                            Is Chain
                        </label>
                        <input
                            type="checkbox"
                            name="is_chain"
                            checked={formData.is_chain}
                            onChange={handleChange}
                            className="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring focus:ring-indigo-300"
                        />
                    </div>
                    <div className="flex items-center justify-center space-x-2">
                        <label htmlFor="is_craft" className="text-gray-700 font-medium">
                            Is Craft
                        </label>
                        <input
                            type="checkbox"
                            name="is_craft"
                            checked={formData.is_craft}
                            onChange={handleChange}
                            className="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring focus:ring-indigo-300"
                        />
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
                        {sauces.map(sauce => ( 
                            <div key={sauce.id}> 
                                <label htmlFor={`sauce-${sauce.id}`} className="pr-5">{sauce.name}</label> 
                                <input 
                                type="checkbox" 
                                id={`sauce-${sauce.id}`} 
                                value={sauce.id} 
                                onChange={() => handleSaucesChange(sauce.id)} 
                                /> 
                        </div> 
                        ))}
                    </div>
                    <div>
                        <label className="block text-gray-700 font-medium m-2">Meat Types</label>
                        {meatTypes.map(meat => ( 
                            <div key={meat.id}> 
                                <label htmlFor={`meat-${meat.id}`} className="pr-5">{meat.name}</label>
                                <input 
                                type="checkbox" 
                                id={`meat-${meat.id}`} 
                                value={meat.id} 
                                onChange={() => handleMeatTypesChange(meat.id)} 
                                /> 
                            </div> 
                        ))}
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
                            value={formData.opening_hours[day]?.open || "08:00"}
                            onChange={(e) => handleOpeningHoursChange(day, "open", e.target.value)}
                            className="w-1/4 px-2 py-1 border rounded-md"
                        />
                        <label className="w-1/4 text-gray-500 text-sm">
                            Closes
                        </label>
                        <input
                            type="time"
                            value={formData.opening_hours[day]?.close || "20:00"}
                            onChange={(e) => handleOpeningHoursChange(day, "close", e.target.value)}
                            className="w-1/4 px-2 py-1 border rounded-md"
                        />
                    </div>
                ))}
                </div>
                <div className="space-y-4">
                {formData.order_ways.map((orderWay, index) => (
                    <div key={index} className="space-y-2 border-b pb-4">
                        <h3 className="text-lg font-medium text-gray-700">
                            Order Method {index + 1}
                        </h3>
                        <div className="flex items-center gap-4">
                            <label className="w-1/4 text-gray-500 text-sm">App Name</label>
                            <input
                                type="text"
                                value={orderWay.app_name || ""}
                                onChange={(e) => handleOrderWaysChange(index, "app_name", e.target.value)}
                                className="w-3/4 px-2 py-1 border rounded-md"
                            />
                        </div>
                        <div className="flex items-center gap-4">
                            <label className="w-1/4 text-gray-500 text-sm">Phone Number</label>
                            <input
                                type="tel"
                                value={orderWay.phone_number || ""}
                                onChange={(e) => handleOrderWaysChange(index, "phone_number", e.target.value)}
                                className="w-3/4 px-2 py-1 border rounded-md"
                            />
                        </div>
                        <div className="flex items-center gap-4">
                            <label className="w-1/4 text-gray-500 text-sm">Website</label>
                            <input
                                type="url"
                                value={orderWay.website || ""}
                                onChange={(e) => handleOrderWaysChange(index, "website", e.target.value)}
                                className="w-3/4 px-2 py-1 border rounded-md"
                            />
                        </div>
                        <button
                            type="button"
                            onClick={() => handleRemoveOrderWay(index)}
                            className="mt-2 px-4 py-2 bg-red-500 text-white rounded-md"
                        >
                            Remove Order Method
                        </button>
                    </div>
                ))}
                <button
                    type="button"
                    onClick={() =>
                        setFormData((prevState) => ({
                            ...prevState,
                            order_ways: [...prevState.order_ways, { app_name: "", phone_number: "", website: "" }],
                        }))
                    }
                    className="px-4 py-2 bg-blue-500 text-white rounded-md"
                >
                    Add Order Method
                </button>
                {formData.social_media_links.map((link, index) => (
                    <div key={index} className="space-y-2 border-b pb-4">
                        <h3 className="text-lg font-medium text-gray-700">
                            Social Media Link {index + 1}
                        </h3>
                        <div className="flex items-center gap-4">
                            <label className="w-1/4 text-gray-500 text-sm">Link</label>
                            <input
                                type="url"
                                value={link || ""}
                                onChange={(e) => handleSocialMediaLinksChange(index, e.target.value)}
                                className="w-3/4 px-2 py-1 border rounded-md"
                            />
                        </div>
                        <button
                            type="button"
                            onClick={() => handleRemoveSocialMediaLink(index)}
                            className="px-2 py-1 bg-red-500 text-white rounded-md"
                        >
                            Remove Link
                        </button>
                    </div>
                 ))}
                 <div className="w-full">
                    <button
                        type="button"
                        onClick={() =>
                            setFormData((prevState) => ({
                                ...prevState,
                                social_media_links: [...prevState.social_media_links, ""],
                            }))
                        }
                        className="px-4 py-2 bg-blue-500 text-white rounded-md"
                    >
                        Add Social Media Link
                    </button>
                 </div>

            </div>
            
            </div>
            <button
                type="submit"
                disabled={addingKebab}
                className="w-full px-4 py-2 mt-4 mb-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-indigo-300"
            >
                {addingKebab ? 'Loading...' : 'Add Kebab'}
            </button>
            {errorMessage.length > 0 && <p className="text-red-500">{errorMessage}</p>}
                </form>
            </div>
        </div>
    )
}