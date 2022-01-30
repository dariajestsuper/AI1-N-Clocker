import ApiClient from "@/js/services/Client";
export const LoginPage = () => {
    const handleSubmit = async () => {
        const username = document.querySelector("#email-input").value;
        const password = document.querySelector("#password-input").value;
        const client = new ApiClient();
        const response = await client.getToken({body:{password,username}});
        console.log(response);
    }
        return(
        <div id="login-form" className="paper">
            <h3>Login to the system</h3>
            <div>
                <input className="text-field" id="email-input" placeholder="Enter email..."/>
                <input className="text-field" id="password-input" placeholder="Enter password..."/>
            </div>
            <button className="button" eventListener={['click',handleSubmit]}>Submit</button>
        </div>
    )
};