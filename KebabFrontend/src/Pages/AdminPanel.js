import React, { useContext, useEffect, useRef, useState } from "react";
import L from 'leaflet'
import icon from "leaflet/dist/images/marker-icon.png";
import iconShadow from "leaflet/dist/images/marker-shadow.png";
import { UserContext } from '../Contexts/AuthContext';
import AddKebabPanel from "../Components/AddKebabPanel";
import EditKebabPanel from "../Components/EditKebabPanel";

let DefaultIcon = L.icon({
    iconUrl: icon,
    shadowUrl: iconShadow,
    iconSize: [25, 41],
    iconAnchor: [12, 41]
  });

L.Marker.prototype.options.icon = DefaultIcon;


export default function AdminPanel(){
  const apiUrl = process.env.REACT_APP_API_URL  
  const mapRef = useRef(null); 
  const [map, setMap] = useState(null)
  const [kebabs, setKebabs] = useState([])
  const [loadingKebabs, setLoadingKebabs] = useState(false)
  const [loadingComments, setLoadingComments] = useState(false)
  const [comments, setComments] = useState([])
  const {token, isLoading} = useContext(UserContext)
    
    useEffect(() => {
      if (!mapRef.current) return;
  
      const map = L.map(mapRef.current).setView([51.206453, 16.16106], 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
  
      const marker = L.marker([51.505, -0.09]).addTo(map);
      marker.bindPopup('<b>Hello world!</b><br>I am a popup.');

      var popup = L.popup();

      function onMapClick(e) {
        const popupContent = document.createElement('div');
        popupContent.innerHTML = `
          <div class='flex flex-col justify-center items-center'>
              <p>Add a new Kebab here</p>
              <button class="text-xl text-white bg-blue-500 hover:bg-blue-600 rounded-lg w-12 h-12 flex items-center justify-center">
                  +
              </button>
          </div>
        `
        popupContent.querySelector('button').addEventListener('click', () => {
          openAddKebabPanel(`${e.latlng.lat}, ${e.latlng.lng}`);
        });

        popup
          .setLatLng(e.latlng)
          .setContent(popupContent)
          .openOn(map);
      }

      map.on('click', onMapClick);

      setMap(map)
  
      return () => {
        map.remove();
      };
    }, []);

    useEffect(() => {
      getKebabs()
    }, [])

    useEffect(() => {
      if(map && mapRef.current) {
        spawnPins(kebabs)
      }
    },[map, kebabs])

    function spawnPins(kebabs) {
      if (map!= null && map && mapRef.current) {
        map.eachLayer((layer) => { if (layer instanceof L.Marker) { layer.remove(); } });

        kebabs.forEach((kebab) => {
  
          const coordinateArray = kebab.coordinates.split(', ');
          const lat = parseFloat(coordinateArray[0]); 
          const lng = parseFloat(coordinateArray[1]); 
          const coordinates = [lat, lng];
  
          try {
            const marker = L.marker(coordinates).addTo(map); //this gives an error for unknown reason upon reload
            marker.bindPopup(`
              <div id="popup-${kebab.id}" class="flex flex-1 flex-col align-center overflow-y-auto text-center">
                <b>${kebab.name}</b>
                <div>${kebab.address}</div>
                <div class="font-semibold m-1">${kebab.status}</div>
                <button id="show-more-button-${kebab.id}" class="font-bold mt-2">Show More</button>
                <button class="font-bold text-blue-500 mt-4" id="edit-kebab-button-${kebab.id}" class="font-bold mt-2">Edit Kebab</button>
              </div>
            `)
            marker.on('popupopen', () => {
              const showMoreButton = document.getElementById(`show-more-button-${kebab.id}`);
              if (showMoreButton) {
                showMoreButton.addEventListener('click', () => {
                  showPanel(kebab.id, 'view');
                });
              }
            
              const editKebabButton = document.getElementById(`edit-kebab-button-${kebab.id}`);
              if (editKebabButton) {
                editKebabButton.addEventListener('click', () => {
                  showPanel(kebab.id, 'edit');
                });
              }
            });
          } catch (error) {
            console.log(error)
          }
        })
      }
    }

    async function getKebabs(){
      try{
        setLoadingKebabs(true)
        const response = await fetch(apiUrl + 'kebabs', {
          method:'GET',
          headers: {
            'Accept' : 'application/json',
            'Content-Type': 'application/json',
          }
        })

        if(!response.ok) {
          setLoadingKebabs(false)
          throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json()

        setLoadingKebabs(false)
        setKebabs(data)

      } catch(error) {
        console.error('Fetch error:', error);
        setLoadingKebabs(false)
      }
    }

    async function getKebabComments(kebabID){
      setLoadingComments(true)
      try {
        const response = await fetch(apiUrl + `kebabs/${kebabID}/comments`, {
          method: 'GET',
          headers: {
            'Accept' : 'application/json',
            'Content-Type': 'application/json',
          }
        })

        if (!response.ok) {
          setLoadingComments(false)
          throw new Error('Network response was not ok ' + response.statusText)
        }
        const data = await response.json()
        setComments(data)
        console.log(data)

      } catch (error) {
        console.log(error)

      } finally {
        setLoadingComments(false)

      }
    }

    const [isPanelVisible, setIsPaneVisible] = useState(false)
    const [panelType, setPanelType] = useState(null); // 'view' or 'edit'

    function showPanel(kebab_id, type = 'view') {
      setClickedKebabID(kebab_id);
      setPanelType(type);
      setIsPaneVisible(true);
      setChosenKebab(kebabs.find(kebab => kebab.id === kebab_id));
      getKebabComments(kebab_id);
      
    }
    
    function hidePanel() {
      setIsPaneVisible(false);
      setPanelType(null);
    }

    const [clickedKebabID, setClickedKebabID] = useState(0)

    const [chosenKebab, setChosenKebab] = useState(null)

    const [isSidePanelOpen, setIsSidePanelOpen] = useState(false)
    const togglePanel = () => setIsSidePanelOpen(!isSidePanelOpen)

    const [isBeingDeleted, setIsBeingDeleted] = useState({})
    async function handleDeleteComment(comment_id) {

      if (window.confirm("Are you sure you want to delete this comment?") === false) {
        return
      }

      setIsBeingDeleted((prev) => ({ ...prev, [comment_id]: true }))

      try {
        const response = await fetch(apiUrl + `admin/delete-comment/${comment_id}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${token}`,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
          }
        });
    
        if (!response.ok) {
          throw new Error('Network response was not ok: ' + response.statusText);
        }
    
        if (response.status !== 204) {
          var data = await response.json()
          console.log('Response Data:', data)
        } else {
          console.log('Comment Deleted')
          await getKebabComments(clickedKebabID);
        }
    
      } catch (error) {
        console.log('Error deleting comment: ', error)

      } finally {
        setIsBeingDeleted((prev) => ({ ...prev, [comment_id]: false }))

      }
    }

    const [isAddKebabPanelOpen, setIsAddKebabPanelOpen] = useState(false)

    function toggleAddKebabPanel() {
      setIsAddKebabPanelOpen(!isAddKebabPanelOpen)
    }

    const [clickedCoordinates, setClickedCoordinates] = useState('')

    function openAddKebabPanel(coordinates) {
      setClickedCoordinates(coordinates)
      setIsAddKebabPanelOpen(true)
    }

    function onKebabAdded() {
      getKebabs()
      setIsAddKebabPanelOpen(false)
    }

    function onKebabEdited() {
      getKebabs()
      hidePanel()
    }

    return (
        <div className="flex h-screen overflow-hidden">
          {isSidePanelOpen &&
          <div id="sidePanel" className={`h-full z-30 bg-white overflow-y-auto shadow-lg ${isSidePanelOpen ? "w-full sm:w-2/5 md:w-1/5" : "hidden"}`}>
            <div id="searchBar" className="w-full">
              <input type="text" placeholder="Search" className="my-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-3/4"></input>
            </div>
            <div className="kebabList">
              {loadingKebabs && <div>Loading kebabs...</div>}
              {kebabs.length === 0 && !loadingKebabs && (<div>No kebabs found</div>)}
              {(kebabs && kebabs.length>0) ? kebabs.map((kebab, index) => (
                <div key={index} className="kebab-item border-b-2">
                  <image src={kebab.logo_link}></image>
                  <h2 className="text-2xl font-semibold">{kebab.name}</h2>
                  <address>{kebab.address}</address>
                  <div>{kebab.status}</div>
                  <div className="flex justify-center flex-col">
                    <button className="mt-2" onClick={()=>{
                      showPanel(kebab.id)
                      }}>Show More
                    </button>
                    <button className="font-bold text-blue-500 my-2" onClick={()=>{
                      setPanelType()
                      showPanel(kebab.id, "edit")
                      }}>Edit Kebab
                    </button>
                  </div>

                </div>
              )) : <></>}
            </div>
          </div>
          }
            <button
            onClick={togglePanel}
            className="bg-blue-500 text-white w-8 h-12 z-40 flex flex-col items-center justify-center fixed self-center rounded-r-md shadow-md hover:bg-blue-600 z-20"
            >
            {isSidePanelOpen ? "<" : ">"}
          </button>
          <div id="mapContainer" className={`flex ${isSidePanelOpen ? "sm:w-3/5 md:w-4/5" : "w-full"} z-10`}>
            <div id="map" className="w-full h-full" ref={mapRef} ></div>
          </div>
          {isPanelVisible && panelType === 'view' && 
            <KebabPanel 
              onAction={hidePanel} 
              kebab={chosenKebab} 
              comments={comments} 
              loadingComments={loadingComments}
              onDelete={handleDeleteComment}
              isBeingDeleted={isBeingDeleted}
            />
          }

          {isPanelVisible && panelType === 'edit' && 
            <EditKebabPanel 
              kebab={chosenKebab} 
              onAction={hidePanel}
              onKebabEdited={onKebabEdited}
            />
          }
          {isAddKebabPanelOpen &&
            <AddKebabPanel 
              coordinates={clickedCoordinates}
              onAction={toggleAddKebabPanel}
              onKebabAdded={onKebabAdded}
            />
          }
        </div>
    )
}

function  KebabPanel({ onAction, kebab, comments, loadingComments, onDelete, isBeingDeleted }) {

  return (
    <div className="right-0 fixed flex justify-center items-center bg-gray-500 z-50 w-full h-full bg-opacity-70">
      <div className="bg-white p-6 sm:rounded-lg shadow-lg relative sm:h-3/4 sm:w-3/4 w-full h-full overflow-y-auto">
        <button onClick={onAction} className="text-xl absolute top-2 right-2 text-gray-600 hover:text-gray-800">
            X
        </button>
        <div className="mt-4">
            <div className="kebab-item">
              <image src={kebab.logo_link}></image>
              <h2 className="text-2xl font-semibold">{kebab.name}</h2>
              <address>{kebab.address}</address>
              <div className="text-md">{kebab.status.toUpperCase()}</div>
              <details>
                <summary className="text-lg font-semibold cursor-default">Show More</summary>
                <div>{kebab.is_chain ? 'chain' : 'not chain'}</div>
                <div>{kebab.is_craft ? 'craft' : 'not craft'}</div>
                <div>{kebab.building_type}</div>
                <div>{kebab.open_year}</div>
                <div>{kebab.google_review}</div>
                <div>{kebab.pyszne_pl_review}</div>
                <div>
                  <details>
                    <summary className="text-lg font-semibold cursor-default">Opening Hours</summary>
                    <ul>
                    {
                    <>
                      <li>
                          Monday: {kebab.opening_hour.monday_open && kebab.opening_hour.monday_close
                              ? `${kebab.opening_hour.monday_open} - ${kebab.opening_hour.monday_close}`
                              : "Closed"}
                      </li>
                      <li>
                          Tuesday: {kebab.opening_hour.tuesday_open && kebab.opening_hour.tuesday_close
                              ? `${kebab.opening_hour.tuesday_open} - ${kebab.opening_hour.tuesday_close}`
                              : "Closed"}
                      </li>
                      <li>
                          Wednesday: {kebab.opening_hour.wednesday_open && kebab.opening_hour.wednesday_close
                              ? `${kebab.opening_hour.wednesday_open} - ${kebab.opening_hour.wednesday_close}`
                              : "Closed"}
                      </li>
                      <li>
                          Thursday: {kebab.opening_hour.thursday_open && kebab.opening_hour.thursday_close
                              ? `${kebab.opening_hour.thursday_open} - ${kebab.opening_hour.thursday_close}`
                              : "Closed"}
                      </li>
                      <li>
                          Friday: {kebab.opening_hour.friday_open && kebab.opening_hour.friday_close
                              ? `${kebab.opening_hour.friday_open} - ${kebab.opening_hour.friday_close}`
                              : "Closed"}
                      </li>
                      <li>
                          Saturday: {kebab.opening_hour.saturday_open && kebab.opening_hour.saturday_close
                              ? `${kebab.opening_hour.saturday_open} - ${kebab.opening_hour.saturday_close}`
                              : "Closed"}
                      </li>
                      <li>
                          Sunday: {kebab.opening_hour.sunday_open && kebab.opening_hour.sunday_close
                              ? `${kebab.opening_hour.sunday_open} - ${kebab.opening_hour.sunday_close}`
                              : "Closed"}
                      </li>
                    </>
                    }
                    </ul>
                  </details>
                </div>
                <div>
                  <details>
                    <summary className="text-lg font-semibold cursor-default">Sauces</summary>
                      <ul>
                        {kebab.sauces.map((sauce, index) => (
                          <li key={index}>
                            {sauce.name}
                          </li>
                        ))}
                      </ul>
                      {kebab.sauces.length === 0 && <p>No sauces</p>}
                  </details>
                </div>
                <div>
                  <details>
                    <summary className="text-lg font-semibold cursor-default">Meat Types</summary>
                      <ul>
                    {kebab.meat_types.map((meat, index) => (
                          <li key={index}>
                            {meat.name}
                          </li>
                        ))}
                      </ul>
                      {kebab.meat_types.length === 0 && <p>No meats</p>}
                  </details>
                </div>
                <div>
                  <details>
                    <summary className="text-lg font-semibold cursor-default">Ways to Order</summary>
                    <ul>
                    {kebab.order_way.map((way, index) => (
                      <li key={index} className="mb-4">
                        <p>{way.app_name}</p>
                        {way.phone_number && <p>Phone number: {way.phone_number}</p> }
                        <a href={way.website}>{way.website}</a>
                      </li>
                    ))}
                    </ul>
                    {kebab.order_way.length === 0 && <p>No ways to order</p>}
                  </details>
                </div>
                <div>
                  <details>
                    <summary className="text-lg font-semibold cursor-default">Social Media</summary>
                    {kebab.social_medias.length > 0 &&
                    <ul>
                    {kebab.social_medias.map((media, index) => (
                          <li key={index}>
                            <a href={media.social_media_link}>{media.social_media_link}</a>
                          </li>
                        ))}
                    </ul>
                    }
                    {kebab.social_medias.length === 0 && <p>No social media</p>}
                  </details>
                </div>
                <div>
                  <details>
                    <summary className="text-lg font-semibold cursor-default">Comments</summary>
                    {loadingComments ?
                    <div>Loading Comments...</div>
                    :
                    comments.length > 0 ?
                      <ul>
                        {comments.map((comment, index) => (
                          <li key={index} className="mb-4 flex flex-col sm:flex-row items-start sm:justify-between">
                            <div className="flex w-full sm:w-auto mb-2 sm:mb-0">
                              <div className="flex-shrink-0 w-12 h-12 bg-gray-300 text-gray-800 rounded-full flex items-center justify-center font-bold mr-4">
                                {comment.user.name.charAt(0).toUpperCase()}
                              </div>
                              <div className="flex-1">
                                <div className="font-bold text-gray-800 text-left text-wrap">{comment.user.name}
                                <div className="italic text-sm font-normal">{comment.user.is_admin ? 'Administrator' : 'User'}</div>
                                </div>
                                
                                <p className="text-gray-600 mt-1 text-wrap break-all">{comment.content}</p>
                              </div>
                            </div>
                            <button
                              id={`delete-comment-${comment.id}`}
                              className="text-red-600 hover:bg-red-500 hover:text-white text-sm font-medium p-2 border-2 border-red-500 self-end sm:self-auto"
                              onClick={() => onDelete(comment.id)}
                              disabled={isBeingDeleted[comment.id]}
                            >
                              {isBeingDeleted[comment.id] ? 'Deleting...' : 'Delete Comment'}
                            </button>
                          </li>
                        ))}
                      </ul>
                      :
                      <div>No comments</div>
                  }
                </details>
                </div>
              </details>
            </div>
        </div>
      </div>
    </div>
)

}
