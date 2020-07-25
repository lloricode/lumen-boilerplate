## Headers

| Header          | Value Sample                        | When to send it                                              |
|-----------------|-------------------------------------|--------------------------------------------------------------|
| Accept          | `{{accept-header}}`                 |                     |
| Content-Type    | `application/x-www-form-urlencoded` | When passing form body.                                      |
| Authorization   | `Bearer {access_token}`             | Requires on private resources.                               |
| Accept-Language |  `en`                               | Optional: default is `en` or value of `config('app.locale')` | 

## Rate limiting


The rate limit window is `{{rate-limit-expires}}` minute(s) per endpoint,
 with most individual calls allowing for `{{rate-limit-attempts}}` requests in each window.



## Tokens

The Access Token lives for `{{access-token-expires}}` minute(s). 
While the Refresh Token lives for `{{refresh-token-expires}}` minute(s).

*You will need to re-authenticate the user when the token expires.*

## Pagination

By default, all fetch requests return the first `{{pagination-limit}}` items in the list. Check the **Query Parameters** for how to control the pagination.

## Limit:

The `?limit=` parameter can be applied to define, how many record should be returned by the endpoint (see also `Pagination`!).

**Usage:**

```
{{api.domain.dev}}/endpoint?limit=100
```

The above example returns 100 resources. 

The `limit` and `page` query parameters can be combined in order to get the next 100 resources:

```
{{api.domain.dev}}/endpoint?limit=100&page=2
```

You can skip the pagination limit to get all the data, by adding `?limit=0`, this will only work if 'skip pagination' is `enabled` on the server.

## **Responses**

Unless otherwise specified, all of API endpoints will return the information that you request in the JSON data format.


#### Standard Response Format

```json
{
    "data": [
        {
            "type": "users",
            "id": "k4nVrEyZvDxaAgb4o971we5lXqOQ8WMo",
            "attributes": {
                "first_name": "Judd",
                "last_name": "Howell",
                "email": "albert62@hotmail.com",
                "created_at": "30/12/2018 04:22:55 PM",
                "created_at_readable": "11 hours ago",
                "created_at_tz": "30/12/2018 08:22:55 AM",
                "created_at_readable_tz": "11 hours ago",
                "updated_at": "30/12/2018 04:22:55 PM",
                "updated_at_readable": "11 hours ago",
                "updated_at_tz": "30/12/2018 08:22:55 AM",
                "updated_at_readable_tz": "11 hours ago"
            }
        },
        {
            "type": "users",
            "id": "aWgkBOwmlyKNLDzM1zrZ70RnveVx1QAG",
            "attributes": {
                "first_name": "Idell",
                "last_name": "Bashirian",
                "email": "josefina00@cole.com",
                "created_at": "30/12/2018 04:22:55 PM",
                "created_at_readable": "11 hours ago",
                "created_at_tz": "30/12/2018 08:22:55 AM",
                "created_at_readable_tz": "11 hours ago",
                "updated_at": "30/12/2018 04:22:55 PM",
                "updated_at_readable": "11 hours ago",
                "updated_at_tz": "30/12/2018 08:22:55 AM",
                "updated_at_readable_tz": "11 hours ago"
            }
        }
    ],
    "meta": {
        "pagination": {
            "total": 53,
            "count": 15,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 4
        }
    },
    "links": {
        "self": "{{api.domain.dev}}/auth/users?page=1",
        "first": "{{api.domain.dev}}/auth/users?page=1",
        "next": "{{api.domain.dev}}/auth/users?page=2",
        "last": "{{api.domain.dev}}/auth/users?page=4"
    }
}
```

#### Header

Header Response:

```
Server →nginx/1.15.5
Content-Type →application/json
Transfer-Encoding →chunked
Connection →keep-alive
Cache-Control →private, must-revalidate
Date →Sun, 30 Dec 2018 19:27:09 GMT
X-RateLimit-Limit →30
X-RateLimit-Remaining →28
X-RateLimit-Reset →1546198068
ETag →"78aaf93274df670f01bb44dd059cd294989b7827"
Content-Language →en
```

## **Query Parameters**

Query parameters are optional, you can apply them to some endpoints whenever you need them.

### Ordering

The `?orderBy=` parameter can be applied to any **`GET`** HTTP request responsible for ordering the listing of the records by a field.

**Usage:**

```
{{api.domain.dev}}/endpoint?orderBy=created_at
```

### Sorting

The `?sortedBy=` parameter is usually used with the `orderBy` parameter.

By default the `orderBy` sorts the data in **ascending** order, if you want the data sorted in **descending** order, you can add `&sortedBy=desc`.

**Usage:**

```
{{api.domain.dev}}/endpoint?orderBy=name&sortedBy=desc
```

Order By Accepts:

- `asc` for Ascending.
- `desc` for Descending.

### Searching

The `?search=` parameter can be applied to any **`GET`** HTTP request.

**Usage:**

#### Search any field:

```
{{api.domain.dev}}/endpoint?search=keyword here
```

> Space should be replaced with `%20` (search=keyword%20here).

#### Search any field for multiple keywords:

```
{{api.domain.dev}}/endpoint?search=first keyword;second keyword
```

#### Search in specific field:
```
{{api.domain.dev}}/endpoint?search=field:keyword here
```

#### Search in specific fields for multiple keywords: 
```
{{api.domain.dev}}/endpoint?search=field1:first field keyword;field2:second field keyword
```

#### Define query condition:

```
{{api.domain.dev}}/endpoint?search=field:keyword&searchFields=name:like
```

Available Conditions: 

- `like`: string like the field. (SQL query `%keyword%`).
- `=`: string exact match.


#### Define query condition for multiple fields:

```
{{api.domain.dev}}/endpoint?search=field1:first keyword;field2:second keyword&searchFields=field1:like;field2:=;
```

### Filtering

The `?filter=` parameter can be applied to any HTTP request. And is used to control the response size, by defining what data you want back in the response.

**Usage:**

Return only ID and Name from that Model, (everything else will be returned as `null`).

```
{{api.domain.dev}}/endpoint?filter=id;status
```

Example Response, including only id and status:

```json
{
  "data": [
    {
      "id": "0one37vjk49rp5ym",
      "status": "approved",
      "products": {
        "data": [
          {
            "id": "bmo7y84xpgeza06k",
            "status": "pending"
          },
          {
            "id": "o0wzxbg0q4k7jp9d",
            "status": "fulfilled"
          }
        ]
      },
      "recipients": {
        "data": [
          {
            "id": "r6lbekg8rv5ozyad"
          }
        ]
      },
      "store": {
        "data": {
          "id": "r6lbekg8rv5ozyad"
        }
      }
    }...
```


### Paginating

The `?page=` parameter can be applied to any **`GET`** HTTP request responsible for listing records (mainly for Paginated data).

**Usage:**

```
{{api.domain.dev}}/endpoint?page=200
```

*The pagination object is always returned in the **meta** when pagination is available on the endpoint.*

```shell
  "data": [...],
  "meta": {
    "pagination": {
      "total": 2000,
      "count": 30,
      "per_page": 30,
      "current_page": 22,
      "total_pages": 1111,
      "links": {
        "previous": "http://api.domain.dev/endpoint?page=21"
      }
    }
  }
```

### Relationships

The `?include=` parameter can be used with any endpoint, only if it supports it. 

How to use it: let's say there's a Driver object and Car object. And there's an endpoint `/cars` that returns all the cars objects. 
The include allows getting the cars with their drivers `/cars?include=drivers`. 

However, for this parameter to work, the endpoint `/cars` should clearly define that it
accepts `driver` as relationship (in the **Available Relationships** section).


## Errors And Error Responses


General Errors:

|  Status Code |       Exception                                        |
|--------------|--------------------------------------------------------|
| 403 | Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException |
| 400 | Symfony\Component\HttpKernel\Exception\BadRequestHttpException |
| 409 | Symfony\Component\HttpKernel\Exception\ConflictHttpException |
| 410 | Symfony\Component\HttpKernel\Exception\GoneHttpException |
| 500 | Symfony\Component\HttpKernel\Exception\HttpException |
| 411 | Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException |
| 405 | Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException |
| 406 | Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException |
| 404 | Symfony\Component\HttpKernel\Exception\NotFoundHttpException |
| 412 | Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException |
| 428 | Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException |
| 503 | Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException |
| 429 | Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException |
| 401 | Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException |
| 415 | Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException |