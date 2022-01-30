export default class ApiClient {
    basePath = '127.0.0.1:8100';
    token = '';

    constructor(token = null) {
        this.token = token;
    }

    async getToken(body) {
        const headers = new Headers();
        headers.append('Content-Type', 'application/json');

        const init = {
            method: 'post',
            headers,
            body,
            mode: 'cors',
            cache: 'default'
        };
        const request = new Request(this.basePath + '/login')
        const response = await fetch(request, init);
        return await response.json();
    }
}