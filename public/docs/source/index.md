---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://viventor.dev/docs/collection.json)

<!-- END_INFO -->

#general
<!-- START_2be1f0e022faf424f18f30275e61416e -->
## api/v1/auth/login

> Example request:

```bash
curl -X POST "http://viventor.dev/api/v1/auth/login" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://viventor.dev/api/v1/auth/login",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/auth/login`


<!-- END_2be1f0e022faf424f18f30275e61416e -->

<!-- START_3cfa5b5223a2e8c461eb874eac708303 -->
## api/v1/users/create

> Example request:

```bash
curl -X POST "http://viventor.dev/api/v1/users/create" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://viventor.dev/api/v1/users/create",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/users/create`


<!-- END_3cfa5b5223a2e8c461eb874eac708303 -->

<!-- START_dc226423a54383379e87b9f6841dc5a0 -->
## api/v1/users/getByPage/{page}/{limit}

> Example request:

```bash
curl -X POST "http://viventor.dev/api/v1/users/getByPage/{page}/{limit}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://viventor.dev/api/v1/users/getByPage/{page}/{limit}",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/users/getByPage/{page}/{limit}`


<!-- END_dc226423a54383379e87b9f6841dc5a0 -->

<!-- START_94e55823360fae7e7fbb1d53d1ca29be -->
## api/v1/users/filter

> Example request:

```bash
curl -X POST "http://viventor.dev/api/v1/users/filter" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://viventor.dev/api/v1/users/filter",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/v1/users/filter`


<!-- END_94e55823360fae7e7fbb1d53d1ca29be -->

