## Boiler Console Commands

# Start App

`php manage start`

To start the application server. See flags below

<ul>
<li>--host 	to specify the host name or ip address</li>
<li>--port 	to specify the usage port while starting app server</li>
<ul>

# Generate App Files.

`php manage create [controller | middleware | notification | model | seeder | socket ] <name>`

This command will generate files with the name provide in the folder directory of the module option. See available flags below.

<ul>
<li>--d 	to create migration for a model</li>
<li>--c 	to create a controller for a model or migration</li>
<li>--s 	to create socket for any create action name</li>
<li>--a 	to create all including migration, model, controller</li>
<ul>

# Database and Migration.

`php manage migrate`

This command will check and run migration files to create and modify database tables. See available flags below

<ul>
<li>--fresh		to drop tables and run fresh migration</li>
<li>--rollback	to rollback migrations</li>
<li>--step		to specify number to steps to rollback</li>
</ul>

`php manage db seed [optional <SeederName>]`

This command is used to run database seeders. To run a particular seeder you can specify seeder name.

# Websocket Commands.

`php manage activate websocket`
`php manage disable websocket`

These commands are you to enable and disabled the usage of websocket in boiler app
if socket has been enable you'll be able to use `php socket <SocketName>` to run a socket
