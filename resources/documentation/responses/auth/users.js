/**
 * @apiDefine UsersResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
  "data": [
    {
      "type": "users",
      "id": "y4V70j6EoA12rDR8Y59pwKebBdPmlMkL",
      "attributes": {
        "first_name": "Randall",
        "last_name": "Yost",
        "email": "freddie07@yahoo.com",
        "real_id": 46,
        "created_at": "13/12/2018 08:24:30 PM",
        "created_at_readable": "9 minutes ago",
        "created_at_tz": "13/12/2018 12:24:30 PM",
        "created_at_readable_tz": "9 minutes ago",
        "updated_at": "13/12/2018 08:24:30 PM",
        "updated_at_readable": "9 minutes ago",
        "updated_at_tz": "13/12/2018 12:24:30 PM",
        "updated_at_readable_tz": "9 minutes ago"
      }
    }
  ],
  "meta": {
    "include": [
      "roles",
      "permissions"
    ],
    "pagination": {
      "total": 53,
      "count": 8,
      "per_page": 15,
      "current_page": 4,
      "total_pages": 4
    }
  },
  "links": {
    "self": "http://lumen-boilerplate.test/user?page=4",
    "first": "http://lumen-boilerplate.test/user?page=1",
    "prev": "http://lumen-boilerplate.test/user?page=3",
    "last": "http://lumen-boilerplate.test/user?page=4"
  }
}
 */