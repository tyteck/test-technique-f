Here is the result of my work as it stands.
I'm sorry to say that I've failed in my task, but after twenty or so hours working on it, it's time to call it a day.

## Expected

Create the backend part of a URL-shortening service from scratch, consisting of the following
parts.
Develop a simple domain model that outlines the fundamental concepts of your service.
Implement the service with a RESTful API. Your service should support operations to add URLs
with their alias and the capability to invoke the alias to get to the original URL.
Use PHP without major web frameworks like Laravel or Symfony. Simplistically implement
persistence, e.g., use SQLite or serialize/deserialize data to/from a file.

Engineer the solution well; choose meaningful levels of abstraction, implement reasonable error
handling, and keep security aspects in mind. Write unit and integration tests for your code to
ensure the application works as expected.

## Done

- [x] Creating web service docker image based on FrankenPhp server
- [x] Creating a mini framework
- [x] Created a router to manage api urls
- [x] Handling SQLite database
- [x] Handling App and service container
- [x] used TDD and php-cs-fixer

## Problems

1. I failed to isolate testing and local environment (and I cannot code without relying on tests)
2. I didn't create the post/path/put part of the minifier.

## Requirements

- docker
- docker compose plugin
- port 80 must be unbound.

## Get dtarted

to start project. After cloning all you need to do is run
`docker compose up -d`
then access `http://localhost` from your browser.
