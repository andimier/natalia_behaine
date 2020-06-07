// var data = JSON.stringify({
//     "action": "create",
//     "user_info": {
//       "email": "dhjdfkghdskjf@fgkjfdlgjfkd.gh",
//       "type": 1,
//       "first_name": "Terry",
//       "last_name": "Jones"
//     }
//   });
  
//   var xhr = new XMLHttpRequest();
//   xhr.withCredentials = true;
  
//   xhr.addEventListener("readystatechange", function () {
//     if (this.readyState === this.DONE) {
//       console.log(this.responseText);
//     }
//   });
  
//   xhr.open("POST", "https://api.zoom.us/v2/users");
//   xhr.setRequestHeader("content-type", "application/json");
//   xhr.setRequestHeader("authorization", "Bearer eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiI1MzM2NDAxYS1iNWRlLTQ0YzEtYmFhYi1hZWNkOTA0MTk5YmUifQ.eyJ2ZXIiOiI2IiwiY2xpZW50SWQiOiJZQkhJV3dJVFRqS252alFySGNsOVJ3IiwiY29kZSI6Ijg4TXBGVE5aZGZfcTJqR0l6TmNRb1c0a0pJc0JSaE9PUSIsImlzcyI6InVybjp6b29tOmNvbm5lY3Q6Y2xpZW50aWQ6WUJISVd3SVRUaktudmpRckhjbDlSdyIsImF1dGhlbnRpY2F0aW9uSWQiOiIwNjM1MWU3YmQ5NzFkZGU3YTNkYjFlNGU3ODA5NDI2ZSIsInVzZXJJZCI6InEyakdJek5jUW9XNGtKSXNCUmhPT1EiLCJncm91cE51bWJlciI6MCwiYXVkIjoiaHR0cHM6Ly9vYXV0aC56b29tLnVzIiwiYWNjb3VudElkIjoibEZmQkppTFBRVkcwMHV1a0d4bGZMZyIsIm5iZiI6MTU5MDg5ODQyMiwiZXhwIjoxNTkwOTAyMDIyLCJ0b2tlblR5cGUiOiJhY2Nlc3NfdG9rZW4iLCJpYXQiOjE1OTA4OTg0MjIsImp0aSI6ImRhNjMwODBjLTA5YjEtNDZhMy1hNWNlLWYxZjM3YzFmMWM1ZCIsInRvbGVyYW5jZUlkIjowfQ.y7isXULWDNhHrxLIXGtOXIZ1kCJNIg-vHawJ8zm3FUAt78vKq4g-cCvbxv-Cv8rFlPClVYiuA8aPgYYGLdOU9g");
  
//   xhr.send(data);