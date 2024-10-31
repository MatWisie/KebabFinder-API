import React from 'react'

export default function LogInPage() {
    return(
        <div>
            <h1>Welcome, Admin</h1>
            <form>
                <input type="email" placeholder='Email'></input>
                <input type="password" placeholder='Password'></input>
                <button>Log In</button>
            </form>
        </div>
    )
}