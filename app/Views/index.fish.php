@{{extends "shared/layout"}}

<h4>Welcome To BoilerPHP</h4>

<h3>User ID: @{{ auth()?->id }}</h3>


