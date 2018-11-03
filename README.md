# crontab
crontab 定时任务

## 安装
```
$ composer require lvinkim/crontab
```

### 使用说明

##### 1. 配置文件

```
$ vi /var/www/html/crontab.ini

[worker:1]
schedule = "* * * * *"
command = "/usr/bin/env php /var/www/html/tests/jobs/job-1.php"
enabled = 0

[worker:2]
schedule = "*/2 * * * *"
command = "/usr/bin/env php /var/www/html/tests/jobs/job-2.php"
enabled = 1

[worker:3]
schedule = "*/3 * * * *"
command = "/usr/bin/env php /var/www/html/tests/jobs/job-3.php"
enabled = 1

```

##### 2. 编写计划任务脚本
```
$ vi /var/www/html/crontab.php

use Lvinkim\Crontab\Crontab;

require dirname(__DIR__) . "/../vendor/autoload.php";

$configPath = dirname(__DIR__) . "/config/crontab.ini";

$crontab = new Crontab($configPath);
$crontab->run(60 * 1000);   // 每 60 秒
``` 

#### 3. 执行计划任务脚本
```
$ php /var/www/html/crontab.php
```

#### 4. 配置说明

```
schedule : 与 linux 的 crotab 一致
command : 要执行的 shell 命令
enabled : 此配置是否生效，1 表示按计划执行， 0 表示暂停使用
```

