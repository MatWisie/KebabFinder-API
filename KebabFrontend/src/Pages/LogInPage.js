import React from 'react'

export default function LogInPage() {

    

    return (
        <div className="flex items-center justify-center min-h-screen bg-gray-100">
          <div className="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
            <h1 className="mb-6 text-3xl font-bold text-center text-gray-800">Welcome, Admin</h1>
            <form className="flex flex-col space-y-4">
              <div>
                <input 
                  type="email" 
                  placeholder="Email" 
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
              </div>
              
              <div>
                <input 
                  type="password" 
                  placeholder="Password" 
                  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
              </div>
              
              <button 
                type="submit" 
                className="w-full px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400"
              >
                Log In
              </button>
            </form>
          </div>
        </div>
      )
      
}