/**
 * @apiDefine RoleResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
    "data": {
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
    },
    "included": [
        {
            "type": "permissions",
            "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
            "attributes": {
                "name": "view backend"
            }
        }
    ]
}
 */