import {create} from "@/js/render/base";

export const Button = ({text,onClick}) => {
    console.log(text,onClick)
    return create({classList:["button"], onClick},[()=>text],'button');
}