## Rede Humaniza SUS - Application Programming Interface (RHS-API)

### Breve Descrição

API REST da Rede Humaniza SUS.

### Endpoints

#### 1. ADD User Device

```
/wp-json/rhs/v1/add-user-device/(?P<device_push_id>[a-zA-Z0-9-]+)
```
Recebe como parâmetro o ID de notificações push do dispositivo mobile, salva esse ID no banco de dados como metadado do usuário (meta_key: _device_id).

Método:  **`POST`**

Parâmetro: **`device_push_id`** (string)

Callback: **`USER_DEVICE_add`**

Autenticação oauth1: **SIM**
#
Retorna JSON:

_Sucesso_:
```javascript
{
  'info': 'Device ID adicionado com sucesso!',
  'device_id': $device_push_id,
  'status': true
}
```
_Erro_:
```javascript
{
  'info': 'Ooops! Erro ao adicionar Device ID! É possível que esse Device ID já exista para esse usuário',
  'device_id': $device_push_id,
  'status': false
}
```

#### 2. GET User Device

```
/wp-json/rhs/v1/get-user-device/(?P<id>[\d]+)
```
Recebe como parâmetro o ID do usuário e retorna o Device ID associado a ele.

Método: **`GET`**

Parâmetro: **`id`** (int)

Callback: **`USER_DEVICE_get`**

Autenticação oauth1: **SIM**
#
Retorna JSON ou Device ID:

_Sucesso_:
```javascript
device_id
```
_Erro_:
```javascript
{
  'info': 'Device ID não existe para esse usuário!',
  'status': false
}
```

#### 3. DELETE User Device
```
/wp-json/rhs/v1/delete-user-device/(?P<id>[\d]+)
```
Recebe como parâmetro o ID do usuário e exclui o device ID associado a ele.

Método: **`DELETE`**

Parâmetro: **`id`** (int)

Callback: **`USER_DEVICE_delete`**

Autenticação oauth1: **SIM**
#
Retorna JSON:

_Sucesso_:
```javascript
{
  'info': 'Device ID excluído com sucesso!',
  'status': true
}
```

_Erro_:
```javascript
{
  'info': 'Ooops! Erro ao excluir Device ID!',
  'status': false
}
```

#### 4. User

```
/wp-json/rhs/v1/user/(?P<id>[\d]+)
```
Recebe como parâmetro o ID do usuário e retorna suas informações.

Método: **`GET`**

Parâmetro: **`id`** (int)

Callback: **`USER_show`**

Autenticação oauth1: **NÃO**
#
Retorna Objeto WP_User em formato JSON

#### 5. Follow

```
/wp-json/rhs/v1/follow/(?P<id>[\d]+)
```
Recebe como parâmetro o ID do usuário que será seguido ou que deixará de ser seguido. Isto é, se o usuário já segue, isso é desfeito. Se não, passa a seguir.

Método: **`POST`**

Parâmetro: **`id`** (int)

Callback: **`USER_follow`**

Autenticação oauth1: **SIM**
#
Retorna JSON (response é `1` se segue, `2` se não):

```javascript
{
  'response': response,
  'user_id': user_id,
  'follow_id': id_seguido
}
```

#### 6. Vote

```
/wp-json/rhs/v1/votes/(?P<id>[\d]+)
```
Recebe como parâmetro o ID do post que receberá o voto e, registra esse voto caso o usuário possa votar no post, caso não, um erro é retornado.

Método: **`POST`**

Parâmetro: **`id`** (int)

Callback **`POST_vote`**

Autenticação oauth1: **SIM**
#
Retorna JSON (data é `true` se usuário pode votar e votou, `false` se não):

```javascript
{
  'response': data,
  'post_id': post_id,
  'total_votes': post_total_votes
}
```