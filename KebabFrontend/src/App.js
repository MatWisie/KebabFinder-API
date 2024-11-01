import logo from './logo.svg';
import './App.css';
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
import RootLayout from './Pages/RootLayout';

const router = createBrowserRouter(
  createRoutesFromElements(
    <>
    <Route 
      path='/' 
      element={<RootLayout />} 
    >
      <Route index element={<AdminPanel />} />
      <Route 
        path='/login' 
        element={<LogInPage />}
      />
      <Route 
        path='/adminpanel' 
        element={<ProtectedRoute><AdminPanel /></ProtectedRoute>}
      />
      <Route
        path='*'
        element={<ErrorPage />}
      />
    </Route>
    </>
  )
);

function App() {
  return (
    <div className="App">
      <RouterProvider router={router} />
    </div>
  );
}

export default App;
