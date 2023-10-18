
## public routes


#### request user login otp
POST `/api/request-otp` requires `identifier` & returns session.

#### login user with otp
POST `/api/verify-otp` requires `id`,`hash`,`otp` & returns token for user with some info.

#### get new qr session
GET `api/qr/` return qr code session.

#### check login session ( both qr and modal )
GET `api/session-check/modal/{hash}/{id}` returns token for user with some info.


## private routes


### getters 

#### user profile
GET `api/user/profile/`.

#### user mobile numbers
GET `api/user/profile/mobile-numbers`.

#### user profile metas
GET `api/user/profile/metas`.

#### user financial informations
GET `api/user/financial-information/`.

#### check if a username is valid
PUT `api/user/check-username`.

### setters

#### update user profile
PUT `api/user/profile/` send fields you want to change.

#### add new mobile number
POST `api/user/mobile-numbers/` send `mobile_number` field.

#### update financial information
PUT `api/user/mobile-numbers/` send fields you want to change.

#### update/create user profile metas
PUT `api/user/profile/metas`.

#### set new username for user
PUT `api/user/set-username`.


### sessions

#### get new modal session
GET `api/user/modal` returns new session for modal and user.

#### claim modal session
GET `api/modal/{hash}/{id}` returns new session for modal and user.

#### claim qr session
GET `api/qr/{hash}/{id}` returns new session for modal and user.