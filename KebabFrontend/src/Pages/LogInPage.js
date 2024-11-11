import {React, useContext, useState} from 'react'
import { useNavigate } from 'react-router-dom';
import { UserContext } from '../Contexts/AuthContext';

export default function LogInPage() {
  const apiUrl = process.env.REACT_APP_API_URL;

  const [formData, setFormData] = useState({ name: '', password: ''});
  const [errorMessage, setErrorMessage] = useState(false)
  const {setToken} = useContext(UserContext)

  const navigate = useNavigate()

  const handleChange = (e) => { 
    const { name, value } = e.target; 
    setFormData((prevData) => ({ ...prevData, [name]: value })); 
  }

  function logIn(event){
      event.preventDefault()
      setErrorMessage('Loading')
      fetch(apiUrl+'admin-login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json' //important
        },
        body: JSON.stringify(formData)
      })
      .then(response => {
        if (!response.ok) {
          
          if (response.status === 401) {
            setErrorMessage('Wrong name or password')
          } else if (response.status === 500) {
            setErrorMessage('Server error')
          } else {
            setErrorMessage('Something went wrong')
          }

          throw new Error('Network response was not ok ' + response.statusText);
        }
      
        const contentType = response.headers.get("content-type");
        
        if (contentType && contentType.includes("application/json")) {
          return response.json();
        } else {
          return response.text();
        }
      })
      .then(data => {
        if (typeof data === 'object' && data.token) {
          localStorage.setItem('token', data.token);
          setToken(data.token)
          console.log("logged in")
          navigate('/adminpanel');
        } else {
          console.log('Received non-JSON response:', data);
        }
      })
      .catch(error => {
        console.error('There was a problem with the login request:', error);
      });
  }

  return (
      <div className="flex items-center justify-center min-h-screen bg-gray-100">
        <div className="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
          <h1 className="mb-6 text-3xl font-bold text-center text-gray-800">Welcome, Admin</h1>
          <form className="flex flex-col space-y-4" onSubmit={logIn}>
            <div>
              <input 
                type="text" 
                placeholder="Username" 
                name="name"
                value={formData.name}
                onChange={handleChange}
                required
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
              />
            </div>
            
            <div>
              <input 
                type="password" 
                placeholder="Password" 
                name="password"
                value={formData.password}
                onChange={handleChange}
                required
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
              />
            </div>
            
            <button 
              type="submit" 
              className="w-full px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
              Log In
            </button>
            <p>{errorMessage}</p>
          </form>
        </div>
      </div>
    )
      
}