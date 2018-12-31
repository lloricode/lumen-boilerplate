/**
 * @apiDefine UsersDeletedResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
  "data": [
    {
      "type": "users",
      "id": "Vq3v1XZ0GrkAYbgGkgxP7M5LJdWlQ26n",
      "attributes": {
        "first_name": "Brennan",
        "last_name": "Bernier",
        "email": "edyth.kuphal@hotmail.com",
        "created_at": "23/12/2018 02:27:56 PM",
        "created_at_readable": "1 hour ago",
        "created_at_tz": "23/12/2018 06:27:56 AM",
        "created_at_readable_tz": "1 hour ago",
        "updated_at": "23/12/2018 03:35:39 PM",
        "updated_at_readable": "51 seconds ago",
        "updated_at_tz": "23/12/2018 07:35:39 AM",
        "updated_at_readable_tz": "51 seconds ago",
        "deleted_at": "23/12/2018 03:35:39 PM",
        "deleted_at_readable": "51 seconds ago",
        "deleted_at_tz": "23/12/2018 07:35:39 AM",
        "deleted_at_readable_tz": "51 seconds ago"
      },
      "relationships": {
        "roles": {
          "data": []
        }
      }
    }
  ],
  "meta": {
    "include": [
      "roles",
      "permissions"
    ],
    "pagination": {
      "total": 1,
      "count": 1,
      "per_page": 15,
      "current_page": 1,
      "total_pages": 1
    }
  },
  "links": {
    "self": "http://lumen-boilerplate.test/user/deleted?include=roles&page=1",
    "first": "http://lumen-boilerplate.test/user/deleted?include=roles&page=1",
    "last": "http://lumen-boilerplate.test/user/deleted?include=roles&page=1"
  }
}
 */