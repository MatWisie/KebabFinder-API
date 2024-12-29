import React, { useContext, useEffect, useState } from "react";
import { UserContext } from "../Contexts/AuthContext";

export default function MeatsPage() {
    const apiUrl = process.env.REACT_APP_API_URL
    const [meats, setMeats] = useState([])
    const [loading, setLoading] = useState(false)
    const [errorMessage, setErrorMessage] = useState('')
    const {token, isLoading} = useContext(UserContext)
    const [chosenMeat, setChosenMeat] = useState(null)
    const [isEditMeatPanelOpen, setIsEditMeatPanelOpen] = useState(false)
    const [isAddMeatPanelOpen, setIsAddMeatPanelOpen] = useState(false)
    const [deleting, setDeleting] = useState(false)
    const [deletingID, setDeletingID] = useState(-1)

    async function getMeats() {
        setLoading(true)
        try {
            var response = await fetch(apiUrl + 'meattypes', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })

            if (!response.ok) {
                var data = await response.json()
                setErrorMessage(data.message)
                throw new Error('Network response was not ok ' + response.statusText)
            }
            var data = await response.json()
            
            setMeats(data)
            
        } catch (error) {
            console.log(error)
        } finally {
            setLoading(false)
        }
    }

    useEffect(()=>{
        getMeats()
    }, [])

    function handleEdit(meat_index) {
        setIsEditMeatPanelOpen(true)
        setChosenMeat(meats[meat_index])
        console.log(isEditMeatPanelOpen)        
    }
    
    function closeEditMeatPanel() {
        setIsEditMeatPanelOpen(false)
    }

    function handleAdd() {
        setIsAddMeatPanelOpen(true)
    }
    function closeAddMeatPanel() {
        setIsAddMeatPanelOpen(false)
    }

    function handleDelete(meat_id) {
        deleteMeat(meat_id)
    }

    async function deleteMeat(meat_id) {
        setDeleting(true)
        setDeletingID(meat_id)
        try {
            var response = await fetch(apiUrl + `meattypes/${meat_id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "Authorization": `Bearer ${token}`
                }
            })

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText)
            }
            getMeats()
            
        } catch (error) {
            console.log(error)
        } finally {
            setDeleting(false)
        }
    }

    return(
        <div className="flex h-screen overflow-hidden">
            <div className="flex flex-col w-full">
            <h1 className="text-2xl font-semibold mt-6">Meats</h1>
            <div className="p-4 sm:w-1/3 w-full mx-auto">
                <button 
                    onClick={handleAdd} 
                    type='submi'
                    className="w-full px-4 py-2 mt-4 mb-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-indigo-300"
                >
                    Add a new Meat
                </button>
                {loading && <p>Loading Meats...</p>}
                {!loading && meats.length === 0 ? <p>No Meats found</p> : ''}
                {errorMessage.length > 0 && <p className="text-red-600">{errorMessage}</p>}
                {meats.length > 0 &&
                <table className="min-w-full border-collapse border border-gray-200">
                    <thead>
                    <tr className="bg-gray-100">
                        <th className="p-2 border border-gray-300">Name</th>
                        <th className="p-2 border border-gray-300">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    {meats.map((meat, index) => (
                        <tr key={meat.id} className="hover:bg-gray-50">
                        <td className="p-2 border border-gray-300 text-wrap break-all">{meat.name}</td>
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
                                onClick={ ()=>{handleDelete(meat.id)} }
                            >
                                🗑️
                            </button>
                            {(deleting && deletingID == meat.id) ? <p className="ml-2">Deleting...</p> : ''}
                            </div>
                        </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
                }
            </div>
            </div>
            {isEditMeatPanelOpen && <EditMeatPanel meat={chosenMeat} onClose={closeEditMeatPanel} onEdited={getMeats} />}
            {isAddMeatPanelOpen && <AddMeatPanel onClose={closeAddMeatPanel} onAdded={getMeats} />}
        </div>
    )
}

function EditMeatPanel({meat, onClose, onEdited}) {
    const apiUrl = process.env.REACT_APP_API_URL
    const {token, isLoading} = useContext(UserContext)
    const [newMeatName, setNewMeatName] = useState(meat.name);
    const [errorMessage, setErrorMessage] = useState('')
    const [loading, setLoading] = useState(false)
    const [success, setSuccess] = useState(false)

    const handleChange = (event) => {
        setNewMeatName(event.target.value);
    }

    async function editMeat(event) {
        event.preventDefault()
        setLoading(true)
        setSuccess(false)
        setErrorMessage(false)
        try {
            var response = await fetch(apiUrl + `meattypes/${meat.id}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    name: newMeatName
                })
            })

            if (!response.ok) {
                var data = await response.json()
                console.log(data.message)
                setErrorMessage(data.message)
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
                        <h1 className="text-2xl pb-12">Edit {meat.name} Meat</h1>
                        <input
                            type="text"
                            name="name"
                            value={newMeatName}
                            onChange={handleChange}
                            placeholder="Enter new name"
                            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                            required
                        />
                        <button 
                            onClick={editMeat} 
                            type='submit'
                            disabled = {loading}
                            className="w-full px-4 py-2 mt-4 mb-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-indigo-300"
                        >
                            {loading ? 'Loading...' : 'Update Meat'}
                        </button>
                        {errorMessage.length > 0 && <p className="text-red-600">{errorMessage}</p>}
                        {success && !loading ? <p className="text-green-600 font-semibold">Meat Updated!</p> : ''}
                    </div>

                </form>
            </div>
        </div>
    )
}

function AddMeatPanel({onClose, onAdded}) {
    const apiUrl = process.env.REACT_APP_API_URL
    const {token, isLoading} = useContext(UserContext)
    const [newMeatName, setNewMeatName] = useState('');
    const [errorMessage, setErrorMessage] = useState('')
    const [loading, setLoading] = useState(false)
    const [success, setSuccess] = useState(false)

    const handleChange = (event) => {
        setNewMeatName(event.target.value);
    }

    async function addMeat(event) {
        event.preventDefault()
        setLoading(true)
        setSuccess(false)
        setErrorMessage(false)
        try {
            var response = await fetch(apiUrl + `meattypes`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    name: newMeatName
                })
            })

            if (!response.ok) {
                var data = await response.json()
                setErrorMessage(data.message)
                throw new Error('Network response was not ok ' + response.statusText)
            }
            var data = await response.json()
            console.log(data)
            setSuccess(true)
            onAdded()
            
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
                        <h1 className="text-2xl pb-12">Add a new Meat</h1>
                        <input
                            type="text"
                            name="name"
                            value={newMeatName}
                            onChange={handleChange}
                            placeholder="Enter new name"
                            className="w-full px-4 py-2 border rounded-md focus:ring focus:ring-indigo-300"
                            required
                        />
                        <button 
                            onClick={addMeat} 
                            type='submit'
                            disabled = {loading}
                            className="w-full px-4 py-2 mt-4 mb-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-indigo-300"
                        >
                            {loading ? 'Loading...' : 'Update Meat'}
                        </button>
                        {errorMessage.length > 0 && <p className="text-red-600">{errorMessage}</p>}
                        {success && !loading ? <p className="text-green-600 font-semibold">Meat Added!</p> : ''}
                    </div>

                </form>
            </div>
        </div>
    )
}