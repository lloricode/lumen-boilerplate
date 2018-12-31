/**
 * @apiDefine UserResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
  "data": {
    "type": "users",
    "id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
    "attributes": {
      "first_name": "System",
      "last_name": "Root",
      "email": "system@system.com",
      "created_at": "13/12/2018 08:24:25 PM",
      "created_at_readable": "13 minutes ago",
      "created_at_tz": "13/12/2018 12:24:25 PM",
      "created_at_readable_tz": "13 minutes ago",
      "updated_at": "13/12/2018 08:24:25 PM",
      "updated_at_readable": "13 minutes ago",
      "updated_at_tz": "13/12/2018 12:24:25 PM",
      "updated_at_readable_tz": "13 minutes ago"
    },
    "relationships": {
      "roles": {
        "data": [
          {
            "type": "roles",
            "id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA"
          }
        ]
      }
    }
  },
  "included": [
    {
      "type": "roles",
      "id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
      "attributes": {
        "name": "system"
      }
    }
  ],
  "meta": {
    "include": [
      "roles",
      "permissions"
    ]
  }
}
 */