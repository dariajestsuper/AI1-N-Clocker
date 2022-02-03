export default class ApiClient {
    basePath = 'http://127.0.0.1:8100';
    token = '';

    constructor(token = null) {
        this.token = token;
    }

    async login(body) {
        const headers = new Headers();

        const init = {
            method: 'post',
            headers,
            body: JSON.stringify(body),
            mode: 'cors',
            cache: 'default'
        };
        const request = new Request(this.basePath + '/authorization_token')
        const response = await fetch(request, init);

        const json =  await response.json();
        this.token = response['token']??'';
        if(this.token.length){
            localStorage.setItem('jwt',this.token);
        }
        return json;
    }
}