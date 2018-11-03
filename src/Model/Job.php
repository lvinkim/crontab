<?php
/**
 * Created by PhpStorm.
 * User: lvinkim
 * Date: 03/11/2018
 * Time: 6:44 PM
 */

namespace Lvinkim\Crontab\Model;


class Job
{
    /**
     * 工作进程 id
     * @var string
     */
    private $id;

    /**
     * crontab 计划 (如每分钟: * * * * *)
     * @var string
     */
    private $schedule;

    /**
     * 真正执行的 command 命令
     * @var string
     */
    private $command;

    /**
     * 是否启用
     * @var bool
     */
    private $enabled;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSchedule(): string
    {
        return $this->schedule;
    }

    /**
     * @param string $schedule
     */
    public function setSchedule(string $schedule): void
    {
        $this->schedule = $schedule;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }


}