import ApiClient from "@/js/services/Client";
import {navigateTo} from "@/index";

const Task = ({ attributes}) => {
    console.log(attributes)
    const {task} = attributes;
    return (
        <div className="task-inside">
            <div>
                <p>{task.description+''}</p>
                <p>{'Assignee: '+task.assignee}</p>
            </div>
            <div>

            <button className="button">REMOVE</button>
            <button className="button">LOG TIME 🕑</button>
            </div>
        </div>
    );
};

export const ProjectsPage = (props)=> {
    const [id] = props.attributes.pathParams;
    const handleAdd = () => {};
    const handleLoadData = async (projectId) => {
        const client = new ApiClient();
        const response = await client.getProject(projectId);
        const container = document.querySelector('#project-container');
        if(response.description) {
            container.textContent='';
            const subtitle = <h3>{response.description}</h3>
            const noTasks = <p id="no-task">No tasks yet!</p>;
                const display=
                    <div className="project paper paper-small">
                        {response.tasks.map((task)=><Task task={task} />)}
                    </div>;
                container.append(subtitle);
                if(response.tasks.length){
                container.append(display)
                }else {
                    container.append(noTasks)
                }

        }
        console.log(response);
    }
    handleLoadData(id);
    return (
        <div id="display">
            <h3>Project Page</h3>
            <button className="button" eventListener={['click', handleAdd]}>ADD</button>
            <div id="project-container">Loading...</div>
        </div>
    )
}