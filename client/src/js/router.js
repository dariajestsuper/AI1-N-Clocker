import VanillaRouter from "vanilla-router";

export default class Router extends VanillaRouter {
    constructor(views, routerMountingId) {
        super({
            mode: 'history',
            page404: function (path) {
                console.log('"/' + path + '" Page not found');
                this.redirectTo('/')
            }
        });
        views.forEach(({rule, handler, options}) => {
            const Component = handler;
            this.add(rule, function (...params) {
                const mountingPoint = document.querySelector(`#${routerMountingId}`);
                mountingPoint.innerHTML = '';
                mountingPoint.append(<Component pathParams={params}/>);
            }, options)
        })
        this.addUriListener();
        this.redirectTo(window.location.pathname);
    }
}