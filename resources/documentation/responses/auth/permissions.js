/**
 * @apiDefine PermissionsResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
  "data": [
  {
    "type": "permissions",
    "id": "Xyo35kNbmqvjJP9zn9aKeGL6Wz1MBwlA",
    "attributes": {
      "name": "view backend"
    }
  }
],
    "meta": {
  "include": [],
      "pagination": {
    "total": 18,
        "count": 15,
        "per_page": 15,
        "current_page": 1,
        "total_pages": 2
  }
},
  "links": {
  "self": "http://lumen-boilerplate.test/permission?page=1",
      "first": "http://lumen-boilerplate.test/permission?page=1",
      "next": "http://lumen-boilerplate.test/permission?page=2",
      "last": "http://lumen-boilerplate.test/permission?page=2"
}
}
 */