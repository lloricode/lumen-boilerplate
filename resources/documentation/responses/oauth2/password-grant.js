/**
 * @apiGroup           OAuth2
 * @apiName            LoginPasswordGrant
 * @api                {post} /oauth/token Login (Password Grant)
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  username user email
 * @apiParam           {String}  password user password
 * @apiParam           {String}  client_id
 * @apiParam           {String}  client_secret
 * @apiParam           {String}  grant_type must be `password`
 * @apiParam           {String}  [scope] you can leave it empty
 *
 * @apiSuccessExample  {json}       Success-Response:
 HTTP/1.1 200 OK
 {
    "token_type": "Bearer",
    "expires_in": 86399,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUz...",
    "refresh_token": "def5020095c7c03ea7fe585fa28c01..."
 }
 * @apiErrorExample Error-Response:
 HTTP/1.1 401 Unauthorized
 {
    "error": "invalid_credentials",
    "message": "The user credentials were incorrect."
 }
 * @apiErrorExample Error-Response:
 HTTP/1.1 401 Unauthorized
 {
    "error": "invalid_client",
    "message": "Client authentication failed"
 }
 */
