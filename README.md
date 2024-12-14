# Backend Developer Position Interview Task at GSM-PAY

## Overview
This task involves implementing two microservices with distinct functionalities for user login and logging login activities. The microservices should follow clean architecture principles, use independent databases, and demonstrate asynchronous communication.

---

## Part One: Login Microservice
Implement a microservice that provides an endpoint for user login.

### Details:
- **Login Credentials:**
  - The user credentials (mobile number and password) should be pre-registered in the system using a **seeder**.
- **API Response Structure:**
  - Design and define an appropriate response structure for the login API.
``` json
{
  "data": {
    // your data here
  },
  "server_time": "2019-08-24T14:15:22Z"
}
```


---

## Part Two: Logger Microservice
Implement a microservice for logging user login activities.

### Details:
- **Functionality:**
  - This microservice should log user login activities asynchronously.
  - It must not be publicly accessible.
- **Access Logs:**
  - Users should be able to retrieve their recent login logs using the token obtained from the login microservice.
- **Storage:**
  - Use a suitable structure for storing the logs.

---

## Notes and Considerations
- **Independent Databases:**
  - Each microservice should have its own database and access only its respective database.
- **No Registration or OTP:**
  - You do not need to implement endpoints for registration or OTP.
  - The initial user credentials should be registered using a seeder.
- **Best Practices:**
  - Using **design patterns** and adhering to **SOLID principles** will positively impact your evaluation.
- **Documentation and Tests:**
  - Providing detailed documentation and writing tests will increase your score.
- **Containerization:**
  - Containerizing the project with Docker is a bonus.
- **Frontend:**
  - No frontend implementation is required.
