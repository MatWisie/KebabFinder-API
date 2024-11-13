import React, { useContext, useState } from "react"
import { UserContext } from "../Contexts/AuthContext";
import { useNavigate } from "react-router-dom";

export default function ChangePasswordPage() {
    const apiUrl = process.env.REACT_APP_API_URL;
    const {token} = useContext(UserContext)
    const [formData, setFormData] = useState({new_password:'', new_password_confirmation:''})
    const [errorMessage, setErrorMessage] = useState('')
    const [successMessage, setSuccessMessage] = useState('')
    const [loading, setLoading] = useState(false)

    const navigate = useNavigate()

    function changePassword(event) {
        event.preventDefault()

        if (!validatePasswords(formData.new_password, formData.new_password_confirmation)){
            return
        }

        setErrorMessage('')
        setLoading(true)

        fetch(apiUrl + 'admin/change-password-first-login', {
            method:'POST',
            headers:{
                'Accept' : 'application/json',
                'Authorization' : `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                response.json()
                .then(data => {
                    setErrorMessage(data.message)
                })
                setLoading(false)
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            setSuccessMessage(data.message)
            setLoading(false)
            setTimeout(() => {}, 1000);
            navigate('/adminpanel')
        })
        .catch(error => {
            console.error('There was a problem with the request:', error);
            setLoading(false)
        });
    }

    const handleChange = (e) => { 
        const { name, value } = e.target; 
        setFormData((prevData) => ({ ...prevData, [name]: value })); 
      }

    function validatePasswords() {
        if (formData.new_password !== formData.new_password_confirmation) {
            setErrorMessage("Passwords need to match")
            return false
        }
        return true
    }

    return (
        <div className="flex items-center justify-center min-h-screen bg-gray-100">
            <div className="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
                <h1 className="mb-6 text-3xl font-bold text-center text-gray-800">Change Password</h1>
                <form className="flex flex-col space-y-4" onSubmit={changePassword}>
                    <input 
                    type="password" 
                    placeholder="New Password" 
                    required 
                    onChange={handleChange}
                    name="new_password"
                    value={formData.new_password}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    />
                    <input 
                    type="password" 
                    placeholder="Confirm New Password"
                    required 
                    onChange={handleChange}
                    name="new_password_confirmation"
                    value={formData.new_password_confirmation}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    />
                    <button 
                    type="submit"
                    className="w-full px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    >Confirm</button>
                </form>
                <p>{loading ? 'Loading' : ''}</p>
                <p className="text-red-500">{errorMessage}</p>
                <p className="text-green-500">{successMessage}</p>
            </div>
        </div>
    )
}