import {create} from "@/js/render/base";

export const LandingPage = () => {
    return create({id: "landing-content", classList: ["content"]}, [
        create({id: "title-landing"}, [() => "Welcome to Clocker"], "h2"),
        create({}, [() => "AI Labs project created by:"], "h4"),
        create({id: "subtitle-wrapper"},
            [
                create({classList: ["subtitle"]}, [() => "Mateusz Małecki"], "p"),
                create({classList: ["subtitle"]}, [() => "Daria Rudowicz"], "p"),
                create({classList: ["subtitle"]}, [() => "Maciej Sikorski"], "p")])
    ])()
};