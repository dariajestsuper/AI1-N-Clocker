import {routerId} from "@/config/consts";
import {create} from "@/js/render/base";
import {Button} from "@/js/components/button";
import {navigateTo} from "@/index";

export const Layout = () => {
    const base = document.createElement("div");
    base.id = "layout";
    const routerBase = document.createElement("div");
    routerBase.id = routerId;
    base.append(Topbar());
    base.append(routerBase);
    return base;
}

const Topbar = () => {
    const children = [
        create({
            classList: ["logo-sign"], onClick: () => {
                navigateTo("/")
            }
        }, [() => 'Clocker 🕑'], 'h1'),
        Button({
            text: 'Login', onClick: () => {
                navigateTo("/login")
            }
        })]
    const bar = create({id: 'topbar'}, children);
    return bar();
}