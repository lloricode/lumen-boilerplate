/**
 * @apiDefine RolesResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
    "data": [
        {
            "type": "roles",
            "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
            "attributes": {
                "name": "system"
            },
            "relationships": {
                "permissions": {
                    "data": [
                        {
                            "type": "permissions",
                            "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY"
                        }
                    ]
                }
            }
        }
    ],
    "included": [
        {
            "type": "permissions",
            "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
            "attributes": {
                "name": "view backend"
            }
        }
    ],
    "meta": {
        "pagination": {
            "total": 6,
            "count": 6,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    },
    "links": {
        "self": "http://lumen-dingo-boilerplate.test/auth/roles?page=1",
        "first": "http://lumen-dingo-boilerplate.test/auth/roles?page=1",
        "last": "http://lumen-dingo-boilerplate.test/auth/roles?page=1"
    }
}
 */