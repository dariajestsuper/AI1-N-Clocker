import {routerId} from "@/config/consts";
import {navigateTo} from "@/index";

const Topbar = ({attributes}) => {
    const isLogged = localStorage.getItem('jwt').length > 10;
    return (
        <div {...attributes}>
            <h1 eventListener={['click',()=>{navigateTo('/')}]}>Clocker 🕑</h1>
            <button id="login-button" className="button" eventListener={['click',()=>{navigateTo('/login')}]}>Login</button>
        </div>
    );
}

export const Layout = () => {
    const loginButton = document.querySelector('#login-button');
    loginButton.addEventListener('login',function (){
        this.replaceWith()
    })
    return (
        <div id="layout">
            <Topbar  className="logo-sign" id="topbar"/>
            <div id={routerId}/>
        </div>);
}