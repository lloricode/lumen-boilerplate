FORMAT: 1A

# Lumen 5.7 Dingo Boilerplate

# User Management [/auth/users]
User resource representation.

## Get all users [GET /auth/users]


+ Parameters
    + page: (integer, optional) - Pagination page
        + Default: 1
    + search: (string, optional) - Search item
    + include: (string, optional) - Include relationship

+ Response 200 (application/json)
    + Body

            {
                "data": [
                    {
                        "type": "users",
                        "id": "X4WYnoOAkjKw0QzZoQ9Dx3RZyvmMl1Gr",
                        "attributes": {
                            "first_name": "Bettie",
                            "last_name": "Tremblay",
                            "email": "ferry.lelah@hotmail.com",
                            "created_at": "29/12/201810:46:35AM",
                            "created_at_readable": "33minutesago",
                            "created_at_tz": "29/12/201802:46:35AM",
                            "created_at_readable_tz": "33minutesago",
                            "updated_at": "29/12/201810:46:35AM",
                            "updated_at_readable": "33minutesago",
                            "updated_at_tz": "29/12/201802:46:35AM",
                            "updated_at_readable_tz": "33minutesago"
                        }
                    }
                ],
                "meta": {
                    "pagination": {
                        "total": 53,
                        "count": 8,
                        "per_page": 15,
                        "current_page": 4,
                        "total_pages": 4
                    }
                },
                "links": {
                    "self": "http://lumen-dingo-boilerplate.test/auth/users?page=4",
                    "first": "http://lumen-dingo-boilerplate.test/auth/users?page=1",
                    "prev": "http://lumen-dingo-boilerplate.test/auth/users?page=3",
                    "last": "http://lumen-dingo-boilerplate.test/auth/users?page=4"
                }
            }

## Show user [GET /auth/users/{id}]


+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "type": "users",
                    "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
                    "attributes": {
                        "first_name": "System",
                        "last_name": "Root",
                        "email": "system@system.com",
                        "created_at": "29/12/201810:46:30AM",
                        "created_at_readable": "1hourago",
                        "created_at_tz": "29/12/201802:46:30AM",
                        "created_at_readable_tz": "1hourago",
                        "updated_at": "29/12/201810:46:30AM",
                        "updated_at_readable": "1hourago",
                        "updated_at_tz": "29/12/201802:46:30AM",
                        "updated_at_readable_tz": "1hourago"
                    }
                }
            }

## Store user [POST /auth/users]


+ Request (application/json)
    + Headers

            Content-Type: application/x-www-form-urlencoded
    + Body

            {
                "first_name": "Lloric",
                "last_name": "Garcia",
                "email": "lloricode@gmail.com",
                "password": "secret"
            }

+ Response 201 (application/json)
    + Body

            {
                "data": {
                    "type": "users",
                    "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
                    "attributes": {
                        "first_name": "Lloric",
                        "last_name": "Garcia",
                        "email": "lloricode@gmail.com",
                        "created_at": "29/12/201810:46:30AM",
                        "created_at_readable": "1hourago",
                        "created_at_tz": "29/12/201802:46:30AM",
                        "created_at_readable_tz": "1hourago",
                        "updated_at": "29/12/201810:46:30AM",
                        "updated_at_readable": "1hourago",
                        "updated_at_tz": "29/12/201802:46:30AM",
                        "updated_at_readable_tz": "1hourago"
                    }
                }
            }

## Update user [PUT /auth/users/{id}]


+ Request (application/json)
    + Headers

            Content-Type: application/x-www-form-urlencoded
    + Body

            {
                "first_name": "Lloric",
                "last_name": "Garcia",
                "email": "lloricode@gmail.com",
                "password": "secret"
            }

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "type": "users",
                    "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
                    "attributes": {
                        "first_name": "Lloric",
                        "last_name": "Garcia",
                        "email": "lloricode@gmail.com",
                        "created_at": "29/12/201810:46:30AM",
                        "created_at_readable": "1hourago",
                        "created_at_tz": "29/12/201802:46:30AM",
                        "created_at_readable_tz": "1hourago",
                        "updated_at": "29/12/201810:46:30AM",
                        "updated_at_readable": "1hourago",
                        "updated_at_tz": "29/12/201802:46:30AM",
                        "updated_at_readable_tz": "1hourago"
                    }
                }
            }