Dummy environment for local multiple projects deployment with traefik as host proxy.

###./run
Usage:
      (sh|bash) run task \[project\]

      task  -   start   recompile docker-compose.override.yml and execute docker-compose up,
                daemon  recompile docker-compose.override.yml and execute docker-compose up -d,
                stop    execute docker-compose stop,
                down    execute docker-compose down -v --remove orphans
                db-dump project name required, execute mysqdump inside database container and save output into gz archive
                usage   print this message

      project - one of the subfolders name from projects folder, if specified run task script from project folder will be executed
  
###Makefile
Usage make target \[project=project_name\]

    target: start - runs start task. make start [project=project_name]. project_name - one of the subfolders name from projects folder.
    target: stop - runs stop task. make stop [project=project_name]. project_name - one of the subfolders name from projects folder.
    target: up - runs daemon task. make up [project=project_name]. project_name - one of the subfolders name from projects folder.
    target: down - runs down task. make down [project=project_name]. project_name - one of the subfolders name from projects folder.
    target: db-dump - runs db-dump task. make db-dump project=project_name. project_name - one of the subfolders name from projects folder.
    target: help - print this help

Traefik basic auth admin:admin