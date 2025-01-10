import React, { useContext, useEffect, useState } from "react";
import { UserContext } from "../Contexts/AuthContext";
import EditKebabPanel from "../Components/EditKebabPanel";

export default function ReportsPage() {
    const apiUrl = process.env.REACT_APP_API_URL
    const {token} = useContext(UserContext)
    const [reports, setReports] = useState([])
    const [loadingReports, setLoadingReports] = useState(false)
    const [errorMessage, setErrorMessage] = useState('')
    const [getReportsEM, setGetReportsEM] = useState('')
    const [isEditKebabPanelOpen, setIsEditKebabPanelOpen] = useState(false)
    const [chosenKebab, setChosenKebab] = useState(null)
    const [kebabs, setKebabs] = useState([])

    async function getReports() {
        setGetReportsEM('')
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
            setGetReportsEM(error)
        } finally {
            setLoadingReports(false)
        }
    }

    async function acceptReport(reportId) {
        setErrorMessage('')
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
            setErrorMessage(error)
            
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
            setErrorMessage(error)
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
          const response = await fetch(apiUrl + 'kebabs', {
            method:'GET',
            headers: {
              'Accept' : 'application/json',
              'Content-Type': 'application/json',
            }
          })
  
          if(!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
          }
          const data = await response.json()
  
          setKebabs(data)
  
        } catch(error) {
          console.error('Fetch error:', error);
        }
      }
    
    useEffect(()=>{
        getReports()
        getKebabs()
    }, [])

    const [activeTab, setActiveTab] = useState("Waiting")

    return(
        <div className="flex h-screen overflow-hidden">
            <div className="flex flex-col w-full overflow-y-auto">
                <h1 className="text-2xl font-semibold mt-6">Reports</h1>
                {loadingReports && <p className="mt-4">Loading Reports...</p>}
                {!loadingReports && reports.length === 0 ? <p className="mt-4">No Reports found</p> : ''}
                {getReportsEM && <p className="mt-4">{errorMessage}</p>}
                <div className="max-w-5xl w-full flex flex-col justify-center align-center mx-auto mt-4">
                    <div id="tabs">
                        <ul className="flex flex-wrap justify-center -mb-px">
                            <li>
                                <button
                                    onClick={() => setActiveTab("Waiting")}
                                    className={`inline-block p-4 border-b-2 rounded-t-lg ${
                                        activeTab === "Waiting"
                                            ? "text-blue-600 border-blue-600 dark:text-blue-500 dark:border-blue-500"
                                            : "border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                    }`}
                                >
                                    Waiting
                                </button>
                            </li>
                            <li>
                                <button
                                    onClick={() => setActiveTab("Accepted")}
                                    className={`inline-block p-4 border-b-2 rounded-t-lg ${
                                        activeTab === "Accepted"
                                            ? "text-green-500 border-green-500 dark:text-green-500 dark:border-green-500"
                                            : "border-transparent hover:text-green-400 hover:border-green-400 dark:hover:text-green-400"
                                    }`}
                                >
                                    Accepted
                                </button>
                            </li>
                            <li>
                                <button
                                    onClick={() => setActiveTab("Refused")}
                                    className={`inline-block p-4 border-b-2 rounded-t-lg ${
                                        activeTab === "Refused"
                                            ? "text-red-500 border-red-500 dark:text-red-500 dark:border-red-500"
                                            : "border-transparent hover:text-red-400 hover:border-red-400 dark:hover:text-red-400"
                                    }`}
                                >
                                    Refused
                                </button>
                            </li>
                        </ul>
                    </div>
                    <ul className="mb-4">
                    {kebabs.length > 0 && reports.length > 0 ?
                    reports.filter((report)=> report.status === activeTab).map((report, index) => (
                        <li key={index} className="grid grid-cols-[1fr_6fr] mx-10 border-2 mt-2 rounded-xl p-2">
                            <div className="m-2">
                                <p>{kebabs.find((kebab)=> kebab.id === report.kebab_id).name}</p>
                                <p>{kebabs.find((kebab)=> kebab.id === report.kebab_id).address}</p>
                                <p><button onClick={()=>{openEditKebabPanel(report.kebab_id)}} className="text-blue-500 hover:underline font-bold">Edit</button></p>
                                <p>User ID: {report.user_id}</p>
                            </div>                        
                            <div className="flex flex-col justify-around">
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
                            <p className="text-red-500 col-start-2">{errorMessage}</p>
                        </li>
                    ))
                : ''}
                    </ul>
                </div>
            </div>
            {isEditKebabPanelOpen && <EditKebabPanel kebab={chosenKebab} onAction={closeEditKebabPanel} onKebabEdited={getKebabs} />}
        </div>
    )
}