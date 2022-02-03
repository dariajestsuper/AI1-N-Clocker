import ApiClient from "@/js/services/Client";
import {navigateTo} from "@/index";

export const AppPage = ()=> {
    const handleGoTo = (id) => {

        navigateTo('/app/projects/'+id);
    }
    const handleLoadData = async () => {
        const client = new ApiClient();
        const response =await client.getProjects();
        const container = document.querySelector('#projects-container');
        if(response.length) {
            container.textContent='';
            response.forEach((project)=>{
                const display=
                    <div className="project paper"
                         eventListener={['click',()=>{handleGoTo(project.id)}]}
                      >
                        <h4>{project.description+''}</h4>
                        <p>TASKS COUNT</p>
                        <p>{project.tasks.length+''}</p>
                    </div>;
                container.append(display);
            })
        }
        console.log(response);
    }
    handleLoadData();
    return (
        <div id="display">
            <h3>This are your projects</h3>
            <div id="projects-container">No projects found</div>
        </div>
    )
}