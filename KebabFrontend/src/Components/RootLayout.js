import React from "react";
import { Outlet } from "react-router-dom";

export default function RootLayout(){
    return(
        <>
        <div className="h-screen flex flex-col" >
            <nav style={{ position: "sticky", top: 0, background:"#fff", zIndex: "1000" }}>
                This is a navbar
            </nav>
            <Outlet />
        </div>
        </>
    )
}