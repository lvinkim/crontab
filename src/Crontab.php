<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 03/11/2018
 * Time: 6:38 PM
 */

namespace Lvinkim\Crontab;


use Jobby\ScheduleChecker;
use Lvinkim\Crontab\Model\Job;
use Swoole\Process;

class Crontab
{
    /** @var Job[] */
    private $jobs;

    /** @var string */
    private $configPath;

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
    }

    public function run(int $period)
    {
        swoole_timer_tick($period, function ($timerId) {
            $this->parseConfig();
            $this->startJobs();
            $this->wait();
        });
    }

    private function wait()
    {
        while (1) {
            $ret = Process::wait();
            if (!$ret) {
                break;
            }
        }
    }

    /**
     * 逐个启动 crontab job
     */
    private function startJobs()
    {
        $scheduleChecker = new ScheduleChecker();
        foreach ($this->jobs as $job) {
            if (!$job->isEnabled()) {
                continue;
            }

            if (!$scheduleChecker->isDue($job->getSchedule())) {
                continue;
            }

            $pid = $this->createJob($job->getCommand());

            printf("[%s] 运行 %s，进程 %s\n", date("Y-m-d H:i:s"), $job->getId(), $pid);

        }
    }

    /**
     * 解析配置文件
     */
    private function parseConfig()
    {
        if (is_readable($this->configPath)) {
            $iniConfig = parse_ini_file($this->configPath, true);

            $this->jobs = [];
            foreach ($iniConfig as $id => $item) {
                $command = strval($item["command"] ?? "");
                $enabled = boolval($item["enabled"] ?? false);
                $schedule = strval($item["schedule"] ?? "* * * * *");

                $job = new Job();
                $job->setId($id);
                $job->setEnabled($enabled);
                $job->setCommand($command);
                $job->setSchedule($schedule);

                $this->jobs[] = $job;
            }
        }
    }

    /**
     * 创建子进程，并返回子进程 id
     * @param $command
     * @return int
     */
    private function createJob($command)
    {
        $process = new Process(function (Process $worker) use ($command) {
            Process::daemon();
            $worker->exec('/bin/sh', ['-c', $command]);
        });
        return $process->start();
    }
}