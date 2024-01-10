# API Documentation

## Get Documents by Year and Month

### Endpoint

- **URL:** `/api/documents`
- **Method:** GET

### Parameters

- `year` (integer, optional): The year for filtering documents.
- `month` (integer, optional): The month for filtering documents.
- `type` (integer, optional): 1 = Committee Report, 2 = Resolutions, 3 = Ordinance. The type of document to filter.
- `tags` (string, optional): Tags of the document

### Request Headers
- **Accept:** `application/json`
- **Authorization:** `Bearer YOUR_ACCESS_TOKEN`

### Example Request
```http
GET /api/documents?year={year}&month={month}&type={document-type}&tags={tags}
```

```http
GET /api/documents?year=2023&month=12&type=1&tags=example_tags
```

### Example Response
```
{
    "data": [
        {
            "id": 2,
            "title": "Aaaaaaaa",
            "author": "Author ABC",
            "branch_id": 1,
            "department_id": 1,
            "division_id": 1,
            "section_id": 1,
            "folder_id": 1,
            "document_access": "1",
            "tags": "tag1, tag2, tag3",
            "created_at": "2024-01-10T02:44:08.000000Z",
            "updated_at": "2024-01-10T02:44:08.000000Z",
            "type": "1",
            "branch": {
                "id": 1,
                "description": "Branch One",
                "status": 1
            },
            "department": {
                "id": 1,
                "description": "Department 1",
                "status": 1
            },
            "division": {
                "id": 1,
                "description": "Division 1",
                "status": 1
            },
            "section": {
                "id": 1,
                "description": "Section 1",
                "status": 1
            },
            "folder": {
                "id": 1,
                "name": "Folder 1",
                "branch_id": 1,
                "department_id": 1,
                "division_id": 1,
                "section_id": 1,
                "created_at": "2024-01-10T02:14:19.000000Z",
                "updated_at": "2024-01-10T02:14:19.000000Z",
                "status": 1
            },
            "files": [
                {
                    "id": 1,
                    "fileable_id": 2,
                    "fileable_type": "App\\Models\\Document",
                    "file_name": "sample.pdf",
                    "file_path": "1/ouPZ72sOZ3d0TmyNrR4o4njbSe9JSsB35c4RwWIS.pdf",
                    "created_at": "2024-01-10T02:44:08.000000Z",
                    "updated_at": "2024-01-10T02:44:08.000000Z"
                },
                {
                    "id": 2,
                    "fileable_id": 2,
                    "fileable_type": "App\\Models\\Document",
                    "file_name": "dummy.pdf",
                    "file_path": "1/MZ4uFOGKEJtPMbKfhwInxCATrOrNlekZ2REaCzNZ.pdf",
                    "created_at": "2024-01-10T02:44:08.000000Z",
                    "updated_at": "2024-01-10T02:44:08.000000Z"
                }
            ]
        },
        ...so on
    ],
    "success": true
}
```

### Example Error Response
```
{
  "error": "Internal Server Error",
  "success": false
}

```

### Notes
Types:
- 1 = Committee Report
- 2 = Resolutions
- 3 = Ordinance
- 4 = Session Meeting

Document Access:
- 1 = Public
- 2 = Private
- 3 = Confidential

Status Codes:
- 200 OK: Successful request.
- 500 Internal Server Error: An error occurred on the server.

## How to get an access token

1. From the root directory of the DMS application.
2. ```php artisan passport:client --client```
3. Save the Client ID and Client Secret in text file.
4. In Postman or similar application. Create a request to generate the access token.
 - Set the request type to <strong>POST</strong>
 - Enter the token endpoint URL in the request field: `http://your-dms-api-domain.com/oauth/token`
 - Set the request headers
   - Accept: application/json
- Set the request body
   - Select the `x-www-form-urlencoded` option
   - Add the following key-value pairs
     - `grant_type`: `client_credentials`
     - `client_id`: `your-client-id`
     - `client_secret`: `your-client-secret`
- Send the request [End]


### Example Response
```
{
    "token_type": "Bearer",
    "expires_in": 31622400,
    "access_token": "encrypted_access_token"
}
```
