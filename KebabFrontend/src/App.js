import './App.css';
import 'leaflet/dist/leaflet.css';
import { useEffect, useState } from 'react'
import {
  createBrowserRouter,
  createRoutesFromElements,
  RouterProvider,
  Route
} from "react-router-dom";

import LogInPage from './Pages/LogInPage';
import AdminPanel from './Pages/AdminPanel';
import ErrorPage from './Pages/ErrorPage';
import ProtectedRoute from './Components/ProtectedRoute';
import RootLayout from './Components/RootLayout';
import { UserContext } from './Contexts/AuthContext';
import ChangePasswordPage from './Pages/ChangePasswordPage';
import SaucesPage from './Pages/SaucesPage';
import MeatsPage from './Pages/MeatsPage';

const router = createBrowserRouter(
  createRoutesFromElements(
    <>
    <Route 
      path='/' 
      element={<RootLayout />} 
    >
      <Route index element={<ProtectedRoute><AdminPanel /></ProtectedRoute>} />
      <Route 
        path='/login' 
        element={<LogInPage />}
      />
      <Route 
        path='/adminpanel' 
        element={<ProtectedRoute><AdminPanel /></ProtectedRoute>}
      />
      <Route 
        path='/sauces' 
        element={<ProtectedRoute><SaucesPage /></ProtectedRoute>}
      />
      <Route 
        path='/meats' 
        element={<ProtectedRoute><MeatsPage /></ProtectedRoute>}
      />
      <Route
        path='/changepassword'
        element={<ProtectedRoute><ChangePasswordPage /></ProtectedRoute>}
      >
      </Route>
      <Route
        path='/editkebab'
        element={<EditKebabPanel></EditKebabPanel>}
      ></Route>
      <Route
        path='*'
        element={<ErrorPage />}
      />
    </Route>
    </>
  )
);

function App() {
  const [token, setToken] = useState(null)
  const [isLoading, setLoading] = useState(true)

  useEffect(()=>{
    setToken(localStorage.getItem('token'))
    setLoading(false)
  }, [token])

  return (
    <div className="App">
      <UserContext.Provider value={{token, setToken, isLoading}}>
        <RouterProvider router={router} />
      </UserContext.Provider>
    </div>
  );
}

export default App;
