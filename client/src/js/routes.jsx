import {LandingPage} from "@/js/views/LandingPage";
import {LoginPage} from "@/js/views/LoginPage";
import {AppPage} from "@/js/views/AppPage";
import {RegisterPage} from "@/js/views/RegisterPage";
import {ProjectsPage} from "@/js/views/ProjectsPage";


export const routes = [
    {rule:'/',handler:LandingPage, options:{}},
    {rule:'/login',handler:LoginPage},
    {rule:'/register',handler:RegisterPage},
    {rule:'/app', handler:AppPage},
    {rule:'/app/projects/{id}', handler:ProjectsPage}
];
