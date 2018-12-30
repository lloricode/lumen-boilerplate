FORMAT: 1A

# Lumen 5.7 Dingo Boilerplate

# User Access [/auth]
User access representation.

## Get current authenticated user. [GET /auth/profile]


+ Parameters
    + include: (string, optional) - Include relationship

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

# User Deletes [/auth/users]
User deletes representation.

## Restore user. [PUT /auth/users/{id}/restore]


+ Parameters
    + include: (string, optional) - Include relationship

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

## Get all deleted users. [GET /auth/users/deleted]


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

## Purge user. [DELETE /auth/users/{id}/purge]


+ Response 204 (application/json)

# User Management [/auth/users]
User resource representation.

## Get all users. [GET /auth/users]


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

## Show user. [GET /auth/users/{id}]


+ Parameters
    + include: (string, optional) - Include relationship

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

## Store user. [POST /auth/users]


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

## Update user. [PUT /auth/users/{id}]


+ Parameters
    + include: (string, optional) - Include relationship

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

## Destroy user. [DELETE /auth/users/{id}]


+ Response 204 (application/json)

# Role Management [/auth/roles]
Role resource representation.

## Get all roles. [GET /auth/roles]


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
                        "type": "roles",
                        "id": "BX0gNpxGL2ymj8zgD9lqnrVZwQaMDkOY",
                        "attributes": {
                            "name": "system"
                        }
                    },
                    {
                        "type": "roles",
                        "id": "X4WYnoOAkjKw0QzZQ6Dx3RZyvmMl1Grq",
                        "attributes": {
                            "name": "admin"
                        }
                    }
                ],
                "meta": {
                    "pagination": {
                        "total": 2,
                        "count": 2,
                        "per_page": 15,
                        "current_page": 1,
                        "total_pages": 1
                    }
                },
                "links": {
                    "self": "http:\/\/lumen-dingo-boilerplate.test\/auth\/roles?page=1",
                    "first": "http:\/\/lumen-dingo-boilerplate.test\/auth\/roles?page=1",
                    "last": "http:\/\/lumen-dingo-boilerplate.test\/auth\/roles?page=1"
                }
            }

## Store role. [POST /auth/roles]


+ Request (application/json)
    + Headers

            Content-Type: application/x-www-form-urlencoded
    + Body

            {
                "name": "executive"
            }

+ Response 201 (application/json)
    + Body

            {
                "data": {
                    "type": "roles",
                    "id": "X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
                    "attributes": {
                        "name": "executive"
                    },
                    "relationships": {
                        "permissions": {
                            "data": []
                        }
                    }
                }
            }

## Show role. [GET /auth/roles/{id}]


+ Parameters
    + include: (string, optional) - Include relationship

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "type": "roles",
                    "id": "X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
                    "attributes": {
                        "name": "executive"
                    },
                    "relationships": {
                        "permissions": {
                            "data": []
                        }
                    }
                }
            }

## Update role. [PUT /auth/roles/{id}]


+ Request (application/json)
    + Headers

            Content-Type: application/x-www-form-urlencoded
    + Body

            {
                "name": "executive"
            }

+ Response 200 (application/json)
    + Body

            {
                "data": {
                    "type": "roles",
                    "id": "X0NDx2YlwZ8mep6og6AM3OqoP1nrkWJa",
                    "attributes": {
                        "name": "executive"
                    },
                    "relationships": {
                        "permissions": {
                            "data": []
                        }
                    }
                }
            }

## Destroy role. [DELETE /auth/roles/{id}]


+ Response 204 (application/json)