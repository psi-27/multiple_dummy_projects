.PHONY: start stop up down db-dump help

# target: start - runs start task. make start [project=project_name]. project_name - one of the subfolders name from projects folder.
start:
	@/bin/sh run start $(project)

# target: stop - runs stop task. make stop [project=project_name]. project_name - one of the subfolders name from projects folder.
stop:
	@/bin/sh run stop $(project)

# target: up - runs daemon task. make up [project=project_name]. project_name - one of the subfolders name from projects folder.
up:
	@/bin/sh run daemon $(project)

# target: down - runs down task. make down [project=project_name]. project_name - one of the subfolders name from projects folder.
down:
	@/bin/sh run down $(project)

# target: db-dump - runs db-dump task. make db-dump project=project_name. project_name - one of the subfolders name from projects folder.
db-dump:
	@/bin/sh run db-dump $(project)

# target: help - print this help
help:
	@egrep "^[^\t]*target:" Makefile