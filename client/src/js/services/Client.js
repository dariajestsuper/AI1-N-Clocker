export default class ApiClient {
    basePath = 'http://127.0.0.1:8100';
    token = '';

    constructor(token = null) {
        this.token = token;
    }
    getToken() {
        return this.token??localStorage.getItem('jwt')
    }
    logout() {
       localStorage.removeItem('jwt');
    }
    async register(body) {
        const headers = new Headers();

        const init = {
            method: 'post',
            headers,
            body: JSON.stringify(body),
            mode: 'cors',
            cache: 'default'
        };
        const request = new Request(this.basePath + '/register')
        const response = await fetch(request, init);
        return await response.json();
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
        this.token = json['token']??'';
        if(this.token.length){
            localStorage.setItem('jwt',this.token);
        }
        console.log(json)
        return json;
    }
    async getProjects() {
        const headers = new Headers();
        headers.append('Authorization',this.getToken());

        const init = {
            method: 'get',
            headers,
            mode: 'cors',
            cache: 'default'
        };
        const request = new Request(this.basePath + '/api/projects')
        const response = await fetch(request, init);

        const json =  await response.json();
        console.log(json)
        return json;
    }
    async getProject(id) {
        const headers = new Headers();
        headers.append('Authorization',this.getToken());

        const init = {
            method: 'get',
            headers,
            mode: 'cors',
            cache: 'default'
        };
        const request = new Request(this.basePath + '/api/projects/'+ id)
        const response = await fetch(request, init);
        const json =await response.json();
        console.log(json)
        return json;
    }
}