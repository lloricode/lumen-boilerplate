/**
 * @apiDefine LocalizationsResponse
 * @apiSuccessExample {json} Success-Response:
 HTTP/1.1 200 OK
 {
    "data": [
        {
            "type": "localizations",
            "id": "ar",
            "attributes": {
                "language": {
                    "code": "ar",
                    "default_name": "Arabic",
                    "locale_name": "العربية"
                },
                "regions": []
            }
        },
        {
            "type": "localizations",
            "id": "en",
            "attributes": {
                "language": {
                    "code": "en",
                    "default_name": "English",
                    "locale_name": "English"
                },
                "regions": [
                    {
                        "code": "en-GB",
                        "default_name": "United Kingdom",
                        "locale_name": "United Kingdom"
                    },
                    {
                        "code": "en-US",
                        "default_name": "United States",
                        "locale_name": "United States"
                    }
                ]
            }
        },
        {
            "type": "localizations",
            "id": "zh",
            "attributes": {
                "language": {
                    "code": "zh",
                    "default_name": "Chinese",
                    "locale_name": "中文"
                },
                "regions": [
                    {
                        "code": "zh-CN",
                        "default_name": "China",
                        "locale_name": "中国"
                    }
                ]
            }
        },
        {
            "type": "localizations",
            "id": "es",
            "attributes": {
                "language": {
                    "code": "es",
                    "default_name": "Spanish",
                    "locale_name": "español"
                },
                "regions": []
            }
        },
        {
            "type": "localizations",
            "id": "fr",
            "attributes": {
                "language": {
                    "code": "fr",
                    "default_name": "French",
                    "locale_name": "français"
                },
                "regions": []
            }
        }
    ]
}
 */