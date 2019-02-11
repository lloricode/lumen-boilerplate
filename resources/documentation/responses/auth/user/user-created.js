/**
 * @apiDefine UserCreatedResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 201 Created
 {
    "data": {
        "type": "users",
        "id": "aWgkBOwmlyKNLDzME1zrZ70RnveVx1QA",
        "attributes": {
            "first_name": "Lloric",
            "last_name": "Garcia",
            "email": "lloricode@gmail.com",
            "created_at": "11/02/2019 06:37:51 PM",
            "created_at_readable": "1 second ago",
            "created_at_tz": "11/02/2019 10:37:51 AM",
            "created_at_readable_tz": "1 second ago",
            "updated_at": "11/02/2019 06:37:51 PM",
            "updated_at_readable": "1 second ago",
            "updated_at_tz": "11/02/2019 10:37:51 AM",
            "updated_at_readable_tz": "1 second ago"
        }
    },
    "meta": {
        "include": [
            "roles",
            "permissions"
        ]
    }
}
 */