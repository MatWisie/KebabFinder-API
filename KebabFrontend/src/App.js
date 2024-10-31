import logo from './logo.svg';
import './App.css';
import {
  createBrowserRouter,
  createRoutesFromElements,
  RouterProvider,
  Route
} from "react-router-dom";

import LogInPage from './Pages/LogInPage';

const router = createBrowserRouter(
  createRoutesFromElements(
    <Route path='/' element={<LogInPage />}>
      <Route path='/login' element={<LogInPage />}></Route>
    </Route>
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
