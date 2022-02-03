import ApiClient from "@/js/services/Client";
import {navigateTo} from "@/index";

export const LoginPage = () => {
    const handleDisplayMessage = (message) => {
        const p = document.querySelector("#login-message");
        p.innerHTML = message;
    }
    const handleSubmit = async () => {
        const username = document.querySelector("#email-input").value;
        const password = document.querySelector("#password-input").value;
        if (!!password && !!username) {
            const client = new ApiClient();
            const response = await client.login({body: {password, username}});
            if (response['status'] === 'error') {
                handleDisplayMessage(response['error_message']);
            }else {
                const eve = new Event('login')
                document.dispatchEvent(eve);
                navigateTo('/app')
            }

        }
    }
    return (
        <div id="login-form" className="paper">
            <h3>Login to the system</h3>
            <div>
                <input className="text-field" id="email-input" placeholder="Enter email..."/>
                <input className="text-field" id="password-input" placeholder="Enter password..."/>
            </div>
            <button className="button" eventListener={['click', handleSubmit]}>Submit</button>
            <p id="login-message"></p>
        </div>
    )
};