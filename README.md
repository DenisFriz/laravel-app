# Laravel API Health Check

This is a simple Laravel project that provides an API endpoint to check the health of infrastructure services (MySQL and Redis).

To get started, first clone the repository:

```bash
git clone https://github.com/DenisFriz/laravel-app.git
cd laravel-app
```

Then start the Docker containers:

```bash
docker compose up -d
```

Wait around 5 minutes until the composer has installed all necessary packages.

Once everything is running, open Postman (or any HTTP client) and make a GET request to:

```bash
http://localhost:8000/api/v1/health-check
```

Make sure to include the following headers:

```bash
Accept: application/json
X-Owner: 123e4567-e89b-12d3-a456-426614174000
```

If both MySQL and Redis are running, the API will respond with:

```bash
{
"db": true,
"cache": true
}
```

To simulate MySQL being down, stop the MySQL container:

```bash
docker compose stop db
```

```bash
{
"db": false,
"cache": true
}
```

If you forget to provide the X-Owner token, you will get:

```bash
{
"error" => "Invalid or missing X-Owner header"
}
```
