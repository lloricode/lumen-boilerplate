/**
 * @apiDefine UsersDeletedResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
    "data": [
        {
            "type": "users",
            "id": "jRL4l3WxMYE8QA68ObnPDvZGkOdg2a1y",
            "attributes": {
                "first_name": "Edwin",
                "last_name": "Flatley",
                "email": "user@user.com",
                "created_at": "30/12/2018 04:22:51 PM",
                "created_at_readable": "18 hours ago",
                "created_at_tz": "30/12/2018 08:22:51 AM",
                "created_at_readable_tz": "18 hours ago",
                "updated_at": "30/12/2018 06:54:58 PM",
                "updated_at_readable": "15 hours ago",
                "updated_at_tz": "30/12/2018 10:54:58 AM",
                "updated_at_readable_tz": "15 hours ago",
                "deleted_at": "30/12/2018 06:54:58 PM",
                "deleted_at_readable": "15 hours ago",
                "deleted_at_tz": "30/12/2018 10:54:58 AM",
                "deleted_at_readable_tz": "15 hours ago"
            }
        },
        {
            "type": "users",
            "id": "X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
            "attributes": {
                "first_name": "Jada",
                "last_name": "Rodriguez",
                "email": "thad92@yahoo.com",
                "created_at": "30/12/2018 04:22:55 PM",
                "created_at_readable": "18 hours ago",
                "created_at_tz": "30/12/2018 08:22:55 AM",
                "created_at_readable_tz": "18 hours ago",
                "updated_at": "31/12/2018 10:51:38 AM",
                "updated_at_readable": "13 seconds ago",
                "updated_at_tz": "31/12/2018 02:51:38 AM",
                "updated_at_readable_tz": "13 seconds ago",
                "deleted_at": "31/12/2018 10:51:38 AM",
                "deleted_at_readable": "13 seconds ago",
                "deleted_at_tz": "31/12/2018 02:51:38 AM",
                "deleted_at_readable_tz": "13 seconds ago"
            }
        }
    ],
    "meta": {
        "include": [
            "roles",
            "permissions"
        ],
        "pagination": {
            "total": 2,
            "count": 2,
            "per_page": 15,
            "current_page": 1,
            "total_pages": 1
        }
    },
    "links": {
        "self": "http://lumen-dingo-boilerplate.test/auth/users/deleted?page=1",
        "first": "http://lumen-dingo-boilerplate.test/auth/users/deleted?page=1",
        "last": "http://lumen-dingo-boilerplate.test/auth/users/deleted?page=1"
    }
}
 */