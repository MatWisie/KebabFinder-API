import React, { useContext, useEffect, useState } from "react";
import { UserContext } from "../Contexts/AuthContext";

export default function SaucesPage() {
    const apiUrl = process.env.REACT_APP_API_URL
    const [sauces, setSauces] = useState([])
    const [errorMessage, setErrorMessage] = useState('')
    const {token, isLoading} = useContext(UserContext)
    const [chosenSauce, setChosenSauce] = useState(null)
    const [isEditSaucePanelOpen, setIsEditSaucePanelOpen] = useState(false)

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

    useEffect(()=>{
        getSauces()
    }, [])

    function handleEdit(sauce_index) {
        setIsEditSaucePanelOpen(true)
        setChosenSauce(sauces[sauce_index])
        console.log(isEditSaucePanelOpen)

    }

    function handleDelete(sauce_index) {
        deleteSauce(sauces[sauce_index])
    }

    async function deleteSauce(sauce) {
        console.log(sauce.id)
    }

    function closeEditSaucePanel() {
        setIsEditSaucePanelOpen(false)
    }

    return(
        <div className="flex h-screen overflow-hidden">
            <div className="flex flex-col w-full">
            <h1 className="text-2xl font-semibold">Sauces</h1>
            <div className="p-4 sm:w-1/3 w-full mx-auto">
                <table className="min-w-full border-collapse border border-gray-200">
                    <thead>
                    <tr className="bg-gray-100">
                        <th className="p-2 border border-gray-300">Name</th>
                        <th className="p-2 border border-gray-300">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    {sauces.map((sauce, index) => (
                        <tr key={sauce.id} className="hover:bg-gray-50">
                        <td className="p-2 border border-gray-300">{sauce.name}</td>
                        <td className="p-2 border border-gray-300">
                            <div className="gap-2">
                            <button
                                className="text-yellow-500 hover:text-yellow-600"
                                title="Edit"
                                onClick={ ()=>{handleEdit(index)} }
                            >
                                ✏️
                            </button>
                            <button
                                className="text-red-500 hover:text-red-600"
                                title="Delete"
                                onClick={ ()=>{handleDelete(index)} }
                            >
                                🗑️
                            </button>
                            </div>
                        </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            </div>
            </div>
            {isEditSaucePanelOpen && <EditSaucePanel sauce={chosenSauce} onClose={closeEditSaucePanel} onEdited={getSauces} />}
        </div>
    )
}

function EditSaucePanel({sauce, onClose, onEdited}) {
    const apiUrl = process.env.REACT_APP_API_URL
    const {token, isLoading} = useContext(UserContext)
    const [newSauceName, setNewSauceName] = useState(sauce.name);
    const [errorMessage, setErrorMessage] = useState('')
    const [loading, setLoading] = useState(false)
    const [success, setSuccess] = useState(false)

    const handleChange = (event) => {
        setNewSauceName(event.target.value);
    }

    async function editSauce(event) {
        event.preventDefault()
        setLoading(true)
        setSuccess(false)
        setErrorMessage(false)
        try {
            var response = await fetch(apiUrl + `saucetypes/${sauce.id}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    name: newSauceName
                })
            })

            if (!response.ok) {
                setErrorMessage('There was an error: ' + response.statusText)
                throw new Error('Network response was not ok ' + response.statusText)
            }
            var data = await response.json()
            console.log(data)
            setSuccess(true)
            onEdited()
            
        } catch (error) {
            console.log(error)
        }finally {
            setLoading(false)
        }
    }

    return (
        <div className="right-0 fixed flex justify-center items-center bg-gray-500 z-50 w-full h-full bg-opacity-70">
            <div className="bg-white p-6 sm:rounded-lg shadow-lg relative sm:h-3/4 sm:w-3/4 w-full h-full overflow-y-auto">
                <button onClick={onClose} className="text-xl absolute top-2 right-2 text-gray-600 hover:text-gray-800">
                    X
                </button>
                <form className="flex justify-center items-center h-full">
                    <div className="sm:w-1/3 w-full">
                        <h1 className="text-2xl pb-12">Edit {sauce.name} Sauce</h1>
                        <input
                            type="text"
                            name="name"
                            value={newSauceName}
                            onChange={handleChange}
                            placeholder="Enter new name"
                            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                            required
                        />
                        <button 
                            onClick={editSauce} 
                            type='submit'
                            disabled = {loading}
                            className="w-full px-4 py-2 mt-4 mb-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-indigo-300"
                        >
                            {loading ? 'Loading...' : 'Update Sauce'}
                        </button>
                        {errorMessage}
                        {success && !loading ? <p className="text-green-600 font-semibold">Sauce Updated!</p> : ''}
                    </div>

                </form>
            </div>
        </div>
    )
}