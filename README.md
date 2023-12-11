# API Documentation

## Get Documents by Year and Month

### Endpoint

- **URL:** `/api/documents`
- **Method:** GET

### Parameters

- `year` (integer, required): The year for filtering documents.
- `month` (integer, required): The month for filtering documents.
- `type` (integer, required): 1 = Committee Report, 2 = Resolutions, 3 = Ordinance. The type of document to filter.

### Example Request
```http
GET /api/documents?year={year}&month={month}&type={document-type}
```

```http
GET /api/documents?year=2023&month=12&type=1
```

### Example Response
```
{
    "data": [
        {
            "id": 1,
            "title": "Possimus id aliqui",
            "author": "Author ABC",
            "branch_id": 2,
            "department_id": 1,
            "division_id": 2,
            "section_id": 5,
            "folder_id": 3,
            "document_access": "1",
            "tags": "tag1, tag2, tag3",
            "file": "3/wYa3izfcKGGaS57MuuybDHFduDIsiM9Zk5DSId5I.pdf",
            "type": "1",
            "created_at": "2023-12-06T21:07:59.000000Z",
            "updated_at": "2023-12-06T21:07:59.000000Z",
            "branch": {
                "id": 2,
                "description": "Branch Two Edited",
                "status": 1
            },
            "department": {
                "id": 1,
                "description": "Department 1 Edited",
                "status": 1
            },
            "division": {
                "id": 2,
                "description": "Division 2 edited",
                "status": 1
            },
            "section": {
                "id": 5,
                "description": "Section 4",
                "status": 1
            },
            "folder": {
                "id": 3,
                "name": "Folder 3",
                "branch_id": 2,
                "department_id": 1,
                "division_id": 2,
                "section_id": 5,
                "created_at": "2023-12-06T16:11:26.000000Z",
                "updated_at": "2023-12-06T16:11:26.000000Z",
                "status": 1
            }
        },
        ... so on
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

Document Access:
- 1 = Public
- 2 = Private
- 3 = Confidential

Status Codes:
- 200 OK: Successful request.
- 500 Internal Server Error: An error occurred on the server.
