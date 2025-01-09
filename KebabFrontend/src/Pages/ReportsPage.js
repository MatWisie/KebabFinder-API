import React, { useContext, useEffect, useState } from "react";
import { UserContext } from "../Contexts/AuthContext";
import EditKebabPanel from "../Components/EditKebabPanel";

export default function ReportsPage() {
    const apiUrl = process.env.REACT_APP_API_URL
    const {token} = useContext(UserContext)
    const [reports, setReports] = useState([])
    const [loadingReports, setLoadingReports] = useState(false)
    const [errorMessage, setErrorMessage] = useState('')
    const [isEditKebabPanelOpen, setIsEditKebabPanelOpen] = useState(false)
    const [chosenKebab, setChosenKebab] = useState(null)
    const [kebabs, setKebabs] = useState([])

    async function getReports() {
        console.log('getting reports')
        try {
            setLoadingReports(true)
            const response = await fetch(apiUrl + "admin/reports",{
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText)
            }
            const data = await response.json()
            console.log(data)
            setReports(data)

        } catch (error) {
            console.log(error)
            setErrorMessage(error)
        } finally {
            setLoadingReports(false)
        }
    }

    async function acceptReport(reportId) {
        try {
            const response = await fetch(apiUrl + `admin/reports/${reportId}/accept`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })

            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText)
            }

            getReports()

        } catch (error) {
            
        } finally {

        }

    }

    async function refuseReport(reportId) {
        try {
            const response = await fetch(apiUrl + `admin/reports/${reportId}/refuse`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
    
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText)
            }

            getReports()

        } catch (error) {
            
        } finally {

        }

    }

    function openEditKebabPanel(kebab_id) {
        var edited_kebab = kebabs.find((kebab)=> kebab.id === kebab_id)
        console.log(edited_kebab)
        setChosenKebab(edited_kebab)
        setIsEditKebabPanelOpen(true)
    }
    function closeEditKebabPanel() {
        setIsEditKebabPanelOpen(false)
    }

    async function getKebabs(){
        try{
          //setLoadingKebabs(true)
          const response = await fetch(apiUrl + 'kebabs', {
            method:'GET',
            headers: {
              'Accept' : 'application/json',
              'Content-Type': 'application/json',
            }
          })
  
          if(!response.ok) {
            //setLoadingKebabs(false)
            throw new Error('Network response was not ok ' + response.statusText);
          }
          const data = await response.json()
  
          //setLoadingKebabs(false)
          setKebabs(data)
  
        } catch(error) {
          console.error('Fetch error:', error);
          //setLoadingKebabs(false)
        }
      }
    
    useEffect(()=>{
        getReports()
        getKebabs()
    }, [])

    return(
        <div className="flex h-screen overflow-hidden">
            <div className="flex flex-col w-full">
                <h1 className="text-2xl font-semibold mt-6">Reports</h1>
                {loadingReports && <p>Loading Reports...</p>}
                {!loadingReports && reports.length === 0 ? <p>No Reports found</p> : ''}
                <div className="max-w-5xl flex flex-column justify-center align-center mx-auto mt-4">
                    <ul>
                    {reports.map((report, index) => (
                        <li key={index} className="grid grid-cols-[1fr_6fr] mx-10 border-2 mt-2 rounded-xl p-2">
                            <div className="m-2">
                                <p>Kebab: {report.kebab_id}</p>
                                <p><button onClick={()=>{openEditKebabPanel(report.kebab_id)}} className="text-blue-500 hover:underline font-bold">Edit</button></p>
                                <p>User: {report.user_id}</p>
                            </div>                        
                            <div>
                                <p>{report.content}</p>
                                <p className="text-sm my-2">Status: {report.status}</p>
                                {report.status === "Waiting" && 
                                <div className="flex justify-around">
                                    <button 
                                    onClick={()=>acceptReport(report.id)} 
                                    className="text-green-500 border-2 border-green-400 p-1 hover:underline"
                                    disabled = {loadingReports}
                                    >
                                        Accept
                                    </button>
                                    <button 
                                    onClick={()=>refuseReport(report.id)} 
                                    className="text-red-500 border-2 border-red-400 p-1 hover:underline"
                                    disabled = {loadingReports}
                                    >
                                        Refuse
                                    </button>
                                </div>
                                }
                            </div>
                        </li>
                    ))}
                    </ul>
                </div>
            </div>
            {isEditKebabPanelOpen && <EditKebabPanel kebab={chosenKebab} onAction={closeEditKebabPanel} onKebabEdited={getKebabs} />}
        </div>
    )
}