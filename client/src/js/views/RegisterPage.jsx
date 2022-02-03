import ApiClient from "@/js/services/Client";
import {navigateTo, rerender} from "@/index";

export const RegisterPage = () => {


    const handleDisplayMessage = (message) => {
        const p = document.querySelector("#register-message");
        p.innerHTML = message;
    }
    const handleSubmit = async () => {
        const username = document.querySelector("#email-input").value;
        const password = document.querySelector("#password-input").value;
        if (!!password && !!username) {
            const client = new ApiClient();
            const response = await client.register({body: {password, username}});
            if (response['status'] === 'error') {
                handleDisplayMessage(response['error_message']);
            }else {
                console.log(response)
                const eve = new Event('register')
                document.dispatchEvent(eve);
                rerender();
                navigateTo('/login')
            }

        }
    }
    return (
        <div id="login-form" className="paper">
            <h3 id="register-title">Register</h3>
            <div>
                <input className="text-field" id="email-input" placeholder="Enter email..."/>
                <input type="password" className="text-field" id="password-input" placeholder="Enter password..."/>
            </div>
            <button className="button" eventListener={['click', handleSubmit]}>Submit</button>
            <p id="register-message"></p>
        </div>
    )
};