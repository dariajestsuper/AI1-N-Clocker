import ApiClient from "@/js/services/Client";
import {navigateTo, rerender} from "@/index";

export const LoginPage = () => {


    const handleDisplayMessage = (message) => {
        const p = document.querySelector("#login-message");
        p.innerHTML = message;
    }
    const handleGoTo = () => {
        navigateTo('/register');
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
                console.log(response)
                const eve = new Event('login')
                document.dispatchEvent(eve);
                rerender();
                navigateTo('/app')
            }

        }
    }
    return (
        <div id="login-form" className="paper">
            <h3>Login to the system</h3>
            <div>
                <input className="text-field" id="email-input" placeholder="Enter username..."/>
                <input type="password" className="text-field" id="password-input" placeholder="Enter password..."/>
            </div>
            <div className="buttons-container">
                <button className="button" eventListener={['click', handleSubmit]}>Submit</button>
                <button className="button" eventListener={['click', handleGoTo]}>Register</button>
            </div>
            <p id="login-message"></p>
        </div>
    )
};