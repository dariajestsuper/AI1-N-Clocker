import {routerId} from "@/config/consts";
import {navigateTo, rerender} from "@/index";
import {isLogged} from "@/js/services/Auth";
import ApiClient from "@/js/services/Client";

export const Layout = () => {

    return (
        <div id="layout">
            <Topbar className="logo-sign" id="topbar"/>
            <div id={routerId}/>
        </div>);
}
const handleClick = () => {
    if(isLogged()){
        const client = new ApiClient()
        client.logout();
        rerender();
    }
    navigateTo('/login')
}
const Topbar = ({attributes}) => {
    return (
        <div {...attributes}>
            <h1 eventListener={['click',()=>{navigateTo('/')}]}>Clocker 🕑</h1>
            <button id="login-button" className="button" eventListener={['click',()=>handleClick()]}>{isLogged()?'Logout':'Login'}</button>
        </div>
    );
}