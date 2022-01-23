import VanillaRouter from "vanilla-router";

export default class Router extends VanillaRouter {
    constructor(views, routerMountingId) {
        super({
            mode: 'history',
            page404: function (path) {
                console.log('"/' + path + '" Page not found');
            }
        });
        views.forEach(({rule, handler, options}) => {
            this.add(rule, function (...params) {
                const mountingPoint = document.querySelector(`#${routerMountingId}`);
                mountingPoint.innerHTML = '';
                mountingPoint.append(handler())
            }, options)
        })
        this.addUriListener();
        this.redirectTo(window.location.pathname);
    }
}