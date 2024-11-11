import { useContext } from 'react';
import { Navigate } from 'react-router-dom';
import { UserContext } from '../Contexts/AuthContext';

export default function ProtectedRoute({ children }) {
    const {token, isLoading} = useContext(UserContext)
    
    if(isLoading){
        return (
            <h1>Loading</h1>
        )
    }else {
        return (
            token ? children : <Navigate to="/login" />
        )
    }


}