import React from 'react'

export default function LogInPage() {

    

    return(
        <div>
            <h1 className="text-3xl font-bold underline">Welcome, Admin</h1>
            <form>
                <input type="email" placeholder='Email'></input>
                <input type="password" placeholder='Password'></input>
                <button>Log In</button>
            </form>
        </div>
    )
}