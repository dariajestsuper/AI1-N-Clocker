import {routerId} from "@/config/consts";
import {navigateTo} from "@/index";

export const Layout = () => {

    return (
        <div id="layout">
            <Topbar className="logo-sign" id="topbar"/>
            <div id={routerId}/>
        </div>);
}

const Topbar = ({attributes}) => {
    return (
        <div {...attributes}>
            <h1 eventListener={['click',()=>{navigateTo('/')}]}>Clocker 🕑</h1>
            <button className="button" eventListener={['click',()=>{navigateTo('/login')}]}>Login</button>
        </div>
    );
}