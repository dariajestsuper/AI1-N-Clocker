import {create} from "@/js/render/base";
import {Button} from "@/js/components/button";
import {Token} from "@/js/services/Client";

export const LoginPage = () => {
    const handleSubmit = async () => {
        const email = document.querySelector("#email-input").value;
        const password = document.querySelector("#password-input").value;
        const client = Token();
        const response = await client.postCredentialsItem({body:{password,email}});
        console.log(response);
    }
    return create({id: "login-form", classList: ["paper"]}, [
        create({}, [() => "Login to the system"], 'h2'),
        create({}, [
            create({id: "email-input"}, [], 'input'),
            create({id: "password-input"}, [], 'input')],
        ),
        Button({text: "Submit", onClick: handleSubmit})
    ])();
};