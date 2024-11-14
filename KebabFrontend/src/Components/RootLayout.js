import React from "react";
import { Outlet } from "react-router-dom";

export default function RootLayout(){
    return(
        <>
        <div style={{ position: "sticky", top: 0, background:"#fff", zIndex: "1000" }}>
            <nav>
                This is a navbar
            </nav>
        </div>
            <Outlet />
        </>
    )
}