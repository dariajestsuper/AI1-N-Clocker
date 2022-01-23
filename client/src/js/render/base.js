export const create = (props,children =[],tag='div') => {
    const {id,classList,onClick} =props
    const element = document.createElement(tag);
    if(id) element.id = id;
    if(classList && classList.length) element.classList = classList;
    element.onclick = onClick;
    if(children.length) {
        children.forEach(child=>{
            element.append(child());
        })
    }
    return () => element;
}

// export class Component {
//     constructor(props, children, tag='div') {
//         this
//     }
//     render() {
//         const {id,className} =props
//         const element = document.createElement(tag);
//         element.id = id;
//         element.className = className;
//         if(this.children.length) {
//             children.forEach(child=>{
//                 element.append(child());
//             })
//         }
//         return () => element;
//     }
// }