import {LandingPage} from "@/js/views/LandingPage";
import {LoginPage} from "@/js/views/LoginPage";

export const routes = [
    {rule:'/',handler:LandingPage, options:{}},
    {rule:'/login',handler:LoginPage}
    // {rule:'/app', handler:()=><p>{localStorage.getItem('jwt')}</p>}
];
