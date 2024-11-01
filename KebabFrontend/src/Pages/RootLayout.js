import React from "react";
import { Outlet } from "react-router-dom";

export default function RootLayout(){
    return(
        <>
        <div>
            <nav>
                This is a navbar
            </nav>
        </div>
            <Outlet />
        </>
    )
}