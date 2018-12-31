/**
 * @apiDefine RolesResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
  "data": [
    {
      "type": "roles",
      "id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
      "attributes": {
        "name": "system"
      }
    }
  ],
  "meta": {
    "include": [],
    "pagination": {
      "total": 2,
      "count": 2,
      "per_page": 15,
      "current_page": 1,
      "total_pages": 1
    }
  },
  "links": {
    "self": "http://lumen-boilerplate.test/role?page=1",
    "first": "http://lumen-boilerplate.test/role?page=1",
    "last": "http://lumen-boilerplate.test/role?page=1"
  }
}
 */