Implement user email change use case.

Use case should be used in 2 places:
- on cli using symfony command
- on api endpoint using http request

Additional requirements:
- notify external stats system about user email change (service: stats_system)
- notify external marketing system about user email change (service: marketing_system)
- log this change

Useful:
- You can use existing existing User and UserRepository classes in AppBundle\Model namespace
- For testing you can use built in php server
