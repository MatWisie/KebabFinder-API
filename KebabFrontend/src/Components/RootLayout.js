import React, { useContext, useEffect } from "react";
import { Outlet } from "react-router-dom";
import { UserContext } from '../Contexts/AuthContext';

export default function RootLayout(){
    const {token, isLoading} = useContext(UserContext)
    useEffect(()=>{

    }, [isLoading])
    return(
        <>
        <div className="h-screen flex flex-col" >
        {token &&
            <nav style={{ position: "sticky", top: 0, background:"#fff", zIndex: "1000" }}>
                This is a navbar
            </nav>
        }
            <Outlet />
        </div>
        </>
    )
}