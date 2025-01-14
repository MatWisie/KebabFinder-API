import React, { useContext, useEffect } from "react";
import { NavLink, Outlet } from "react-router-dom";
import { UserContext } from "../Contexts/AuthContext";

export default function RootLayout() {
  const { token, isLoading } = useContext(UserContext);

  useEffect(() => {

  }, [isLoading]);

  return (
    <div className="h-screen flex flex-col">
      {token && (
        <nav className="sticky top-0 bg-white z-50 shadow-md">
          <ul className="flex justify-around items-center py-4">
            <li>
              <NavLink
                to="/adminpanel"
                className={({ isActive }) =>
                  `text-lg transition-colors ${
                    isActive ? "text-blue-500 font-bold" : "text-gray-700 font-medium"
                  } hover:text-blue-400`
                }
              >
                AdminPanel
              </NavLink>
            </li>
            <li>
              <NavLink
                to="/sauces"
                className={({ isActive }) =>
                  `text-lg transition-colors ${
                    isActive ? "text-blue-500 font-bold" : "text-gray-700 font-medium"
                  } hover:text-blue-400`
                }
              >
                Sauces
              </NavLink>
            </li>
            <li>
              <NavLink
                to="/meats"
                className={({ isActive }) =>
                  `text-lg transition-colors ${
                    isActive ? "text-blue-500 font-bold" : "text-gray-700 font-medium"
                  } hover:text-blue-400`
                }
              >
                Meats
              </NavLink>
            </li>
            <li>
              <NavLink
                to="/reports"
                className={({ isActive }) =>
                  `text-lg transition-colors ${
                    isActive ? "text-blue-500 font-bold" : "text-gray-700 font-medium"
                  } hover:text-blue-400`
                }
              >
                Reports
              </NavLink>
            </li>
          </ul>
        </nav>
      )}
      <Outlet />
    </div>
  );
}
