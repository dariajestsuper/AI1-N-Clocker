<?php


namespace App\Controller;


use App\Configuration\EntityManager;
use App\Entity\Project;
use App\Entity\Task;
use App\Entity\TimeLog;
use App\Entity\User;
use App\Exception\ValidationException;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use App\Repository\TimeLogRepository;
use App\Repository\UserRepository;
use App\Service\JwtService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController
{
    private ProjectRepository $projectRepository;
    private UserRepository $userRepository;
    private TaskRepository $taskRepository;
    private TimeLogRepository $timeLogRepository;

    public function __construct()
    {
        $em = EntityManager::getEntityManager();
        $this->projectRepository = ProjectRepository::create($em);
        $this->userRepository = UserRepository::create($em);
        $this->taskRepository = TaskRepository::create($em);
        $this->timeLogRepository = TimeLogRepository::create($em);
    }

    public function getProject(Request $request, int $id): Response
    {
        $project = $this->projectRepository->findOneBy(['id' => $id]);

        return new Response(
            json_encode(
                $project
                ?? ['status' => 'No results']
            ), Response::HTTP_OK
        );
    }

    /**
     * @throws ValidationException
     */
    public function postProject(Request $request): Response
    {
        $body = json_decode($request->getContent(), true);
        $this->validatePostProject($body);
        $clientId = $body['clientId'];
        $description = $body['description'];
        $project = new Project();
        if ($clientId === 'me') {
            $user = $this->getMe($request);
        } else {
            $user = $this->userRepository->findOneBy(
                ['id' => (int)$clientId]
            );
        }
        if (!$user instanceof User) {
            return new Response(json_encode(["status" => "No client found"]), Response::HTTP_OK);
        }
        $project
            ->setClient($user)
            ->setDescription((string)$description);
        $em = $this->projectRepository->getEntityManager();
        $em->persist($project);
        $em->flush();

        return new Response(
            json_encode($project->getId() ?? ['status' => 'No results']),
            !!$project->getId() ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
        );
    }

    public function postProjectTask(Request $request, int $id): Response
    {
        $body = json_decode($request->getContent(), true);
        $this->validatePostProjectTask($body);
        if ($body['assigneeId'] === "me") {
            $user = $this->getMe($request);
        } else {
            $user = $this->userRepository->findOneBy(
                ['id' => (int)$body['assigneeId']]
            );
        }
        $project = $this->projectRepository->findOneBy(["id" => $id]);
        if (!$project instanceof Project) {
            return new Response(json_encode(['status' => 'No results']), Response::HTTP_BAD_REQUEST);
        }

        $task = new Task();
        $task->setProject($project);
        $task->setAssignee($user);
        $task->setDescription($body['description']);
        $em = $this->projectRepository->getEntityManager();
        $project->addTask($task);
        $em->persist($project);
        $em->flush();

        return new Response(json_encode(['status' => 'ok']), Response::HTTP_CREATED);
    }

    public function getTaskLogs(Request $request, int $projectId, int $taskId): Response
    {
        $task = $this->taskRepository->findOneByProjectIdAndId($projectId, $taskId);
        if (!$task instanceof Task) {
            return new Response(json_encode(['status' => 'No results']), Response::HTTP_BAD_REQUEST);
        }

        return new Response(json_encode($task->getTimeLogs()->toArray()), Response::HTTP_OK);
    }

    public function postLogTime(Request $request, int $projectId, int $taskId): Response
    {
        $body = json_decode($request->getContent(), true);
        $this->validatePostLogTime($body);
        $task = $this->taskRepository->findOneByProjectIdAndId($projectId, $taskId);
        if (!$task instanceof Task) {
            return new Response(json_encode(['status' => 'No results']), Response::HTTP_BAD_REQUEST);
        }
        $timeLog = new TimeLog();
        $em = $this->taskRepository->getEntityManager();
        $timeLog
            ->setStart(new \DateTime($body['start']))
            ->setEnd(!!$body['stop'] ? new \DateTime($body['stop']) : null);
        $em->persist($timeLog);
        $task->addTimeLog($timeLog);
        $em->persist($task);
        $em->flush();

        return new Response(json_encode(['status' => 'ok']), Response::HTTP_CREATED);
    }

    public function postEndTimeLog(Request $request, int $projectId, int $taskId, int $logId): Response
    {
        $body = json_decode($request->getContent(), true);
        $this->validatePostEndLogTime($body);
        $log = $this->timeLogRepository->findByProjectIdAndTaskIdAndId($projectId, $taskId, $logId);
        if (!$log instanceof TimeLog) {
            return new Response(json_encode(['status' => 'No results']), Response::HTTP_BAD_REQUEST);
        }
        $log->setEnd(new \DateTime($body['stop']));
        $em = $this->timeLogRepository->getEntityManager();
        $em->persist($log);
        $em->flush();

        return new Response(json_encode(['status' => 'ok']), Response::HTTP_CREATED);
    }

    public function deleteTask(Request $request, int $projectId, int $taskId): Response
    {
        $task = $this->taskRepository->findOneByProjectIdAndId($projectId, $taskId);
        if (!$task instanceof Task) {
            return new Response(json_encode(['status' => 'No results']), Response::HTTP_BAD_REQUEST);
        }
        $em = $this->taskRepository->getEntityManager();
        $em->remove($task);
        $em->flush();
        return new Response(json_encode(['status' => 'ok']), Response::HTTP_OK);
    }

    public function deleteProject(Request $request, int $projectId): Response
    {
        $project = $this->projectRepository->findOneBy(['id'=>$projectId]);
        if (!$project instanceof Project) {
            return new Response(json_encode(['status' => 'No results']), Response::HTTP_BAD_REQUEST);
        }
        $em = $this->projectRepository->getEntityManager();
        $em->remove($project);
        $em->flush();
        return new Response(json_encode(['status' => 'ok']), Response::HTTP_OK);
    }

    private function validatePostProjectTask(array $body)
    {
        if (!isset($body['assigneeId']) || !isset($body['description'])) {
            throw new ValidationException('Missing keys in POST body');
        }
    }

    private function validatePostProject(array $body)
    {
        if (!isset($body['clientId']) || !isset($body['description'])) {
            throw new ValidationException('Missing keys in POST body');
        }
    }

    private function validatePostLogTime(array $body)
    {
        if (!isset($body['start'])) {
            throw new ValidationException('Missing keys in POST body');
        }
    }

    private function validatePostEndLogTime(array $body)
    {
        if (!isset($body['stop'])) {
            throw new ValidationException('Missing keys in POST body');
        }
    }

    private function getMe(Request $request): User
    {
        /** @var User $user */
        $user = $this->userRepository->findOneBy(
            ['username' => JwtService::decode($request->headers->get('Authorization'))->getUsername()]
        );

        return $user;
    }
}