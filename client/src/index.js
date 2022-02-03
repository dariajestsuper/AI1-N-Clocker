import '@/styles/index.scss'
import {Layout} from "@/js/layout";
import Router from "@/js/router";
import {routes} from "@/js/routes";
import {routerId} from "@/config/consts";

export const rerender = () => {
    const app = document.querySelector('#root')
    app.innerHTML = '';
    app.append(<Layout/>)
};

const app = document.querySelector('#root')

app.append(<Layout/>);

const router = new Router(routes,routerId);

const navigateTo = (path, state, silent) => {
    if(document.location.pathname !== path) {
        router.navigateTo(path, state, silent)
    }
}
export {navigateTo};
