import {ApiClient} from "@/js/services/ApiClient";

class Client extends ApiClient {
    constructor(token) {
        super();
        this.authentications['oauth2'].accessToken = token;
        this.basePath = loadConfiguration()?.apiUrl?.slice(0, -1) || '';
        /// #if OAUTH_FLOW === 'password'
        this.defaultHeaders = { credentials: 'no' };
        /// #else
        /// #code this.enableCookies = true;
        /// #endif
    }
}

export const Customers = (token) => new CustomersApi(new Client(token));