import {ApiClient, TokenApi, UserApi} from "@/js/services/ApiClient";

class Client extends ApiClient {
    constructor(token = null) {
        super();
        if(token) this.authentications['oauth2'].accessToken = token;
        this.basePath = 'http://localhost:8100/'.replace(/\/+$/, '');
        this.defaultHeaders = { credentials: 'no' };
        //this.enableCookies = true;
    }
}

export const Users = (token) => new UserApi(new Client(token));
export const Token = () => new TokenApi(new Client(null))