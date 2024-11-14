import React, { useEffect, useRef } from "react";
import L from 'leaflet'
import icon from "leaflet/dist/images/marker-icon.png";
import iconShadow from "leaflet/dist/images/marker-shadow.png";

let DefaultIcon = L.icon({
    iconUrl: icon,
    shadowUrl: iconShadow,
    iconSize: [25, 41],
    iconAnchor: [12, 41]
  });

L.Marker.prototype.options.icon = DefaultIcon;


export default function AdminPanel(){
    const mapRef = useRef(null); 
    
    useEffect(() => {
      if (!mapRef.current) return;
  
      const map = L.map(mapRef.current).setView([51.505, -0.09], 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
  
      const marker = L.marker([51.505, -0.09]).addTo(map);
      marker.bindPopup('<b>Hello world!</b><br>I am a popup.');
  
      return () => {
        map.remove();
      };
    }, []);

    return (
        <div className="flex-col">

              <div className="">
                <div className="" ref={mapRef} style={{ minHeight: '600px', width: '100%' }}> {/* Map will be rendered here */} </div>

              </div>

              <div className="searchBar">
                <input type="text" placeholder="Search" className=" my-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></input>
              </div>
              <div className="kebabList"></div>
        </div>
    )
}