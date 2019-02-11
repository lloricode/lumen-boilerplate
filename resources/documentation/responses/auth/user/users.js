/**
 * @apiDefine UsersResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
    "data": [
        {
            "type": "users",
            "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
            "attributes": {
                "first_name": "System",
                "last_name": "Root",
                "email": "system@system.com",
                "created_at": "30/12/2018 04:22:50 PM",
                "created_at_readable": "18 hours ago",
                "created_at_tz": "30/12/2018 08:22:50 AM",
                "created_at_readable_tz": "18 hours ago",
                "updated_at": "30/12/2018 04:22:50 PM",
                "updated_at_readable": "18 hours ago",
                "updated_at_tz": "30/12/2018 08:22:50 AM",
                "updated_at_readable_tz": "18 hours ago"
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
            "count": 15,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 4
        }
    },
    "links": {
        "self": "http://lumen-dingo-boilerplate.test/auth/users?page=1",
        "first": "http://lumen-dingo-boilerplate.test/auth/users?page=1",
        "next": "http://lumen-dingo-boilerplate.test/auth/users?page=2",
        "last": "http://lumen-dingo-boilerplate.test/auth/users?page=4"
    }
}
 */