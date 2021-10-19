[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / HttpConfiguration

# Interface: HttpConfiguration

## Hierarchy

- `AxiosRequestConfig`

  ↳ **`HttpConfiguration`**

## Table of contents

### Properties

- [adapter](HttpConfiguration.md#adapter)
- [auth](HttpConfiguration.md#auth)
- [baseURL](HttpConfiguration.md#baseurl)
- [cancelToken](HttpConfiguration.md#canceltoken)
- [data](HttpConfiguration.md#data)
- [decompress](HttpConfiguration.md#decompress)
- [etag](HttpConfiguration.md#etag)
- [headers](HttpConfiguration.md#headers)
- [httpAgent](HttpConfiguration.md#httpagent)
- [httpsAgent](HttpConfiguration.md#httpsagent)
- [maxBodyLength](HttpConfiguration.md#maxbodylength)
- [maxContentLength](HttpConfiguration.md#maxcontentlength)
- [maxRedirects](HttpConfiguration.md#maxredirects)
- [method](HttpConfiguration.md#method)
- [params](HttpConfiguration.md#params)
- [proxy](HttpConfiguration.md#proxy)
- [responseType](HttpConfiguration.md#responsetype)
- [socketPath](HttpConfiguration.md#socketpath)
- [timeout](HttpConfiguration.md#timeout)
- [timeoutErrorMessage](HttpConfiguration.md#timeouterrormessage)
- [transformRequest](HttpConfiguration.md#transformrequest)
- [transformResponse](HttpConfiguration.md#transformresponse)
- [transitional](HttpConfiguration.md#transitional)
- [url](HttpConfiguration.md#url)
- [validateStatus](HttpConfiguration.md#validatestatus)
- [withCredentials](HttpConfiguration.md#withcredentials)
- [xsrfCookieName](HttpConfiguration.md#xsrfcookiename)
- [xsrfHeaderName](HttpConfiguration.md#xsrfheadername)

### Methods

- [onDownloadProgress](HttpConfiguration.md#ondownloadprogress)
- [onUploadProgress](HttpConfiguration.md#onuploadprogress)
- [paramsSerializer](HttpConfiguration.md#paramsserializer)

## Properties

### adapter

• `Optional` **adapter**: `AxiosAdapter`

#### Inherited from

AxiosRequestConfig.adapter

#### Defined in

node_modules/axios/index.d.ts:63

___

### auth

• `Optional` **auth**: `AxiosBasicCredentials`

#### Inherited from

AxiosRequestConfig.auth

#### Defined in

node_modules/axios/index.d.ts:64

___

### baseURL

• `Optional` **baseURL**: `string`

#### Inherited from

AxiosRequestConfig.baseURL

#### Defined in

node_modules/axios/index.d.ts:53

___

### cancelToken

• `Optional` **cancelToken**: `CancelToken`

#### Inherited from

AxiosRequestConfig.cancelToken

#### Defined in

node_modules/axios/index.d.ts:78

___

### data

• `Optional` **data**: `any`

#### Inherited from

AxiosRequestConfig.data

#### Defined in

node_modules/axios/index.d.ts:59

___

### decompress

• `Optional` **decompress**: `boolean`

#### Inherited from

AxiosRequestConfig.decompress

#### Defined in

node_modules/axios/index.d.ts:79

___

### etag

• `Optional` **etag**: `Object`

#### Type declaration

| Name | Type |
| :------ | :------ |
| `enabled?` | `boolean` |
| `manifestKey?` | `string` |

#### Defined in

[resources/lib/types/config.ts:22](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/config.ts#L22)

___

### headers

• `Optional` **headers**: `any`

#### Inherited from

AxiosRequestConfig.headers

#### Defined in

node_modules/axios/index.d.ts:56

___

### httpAgent

• `Optional` **httpAgent**: `any`

#### Inherited from

AxiosRequestConfig.httpAgent

#### Defined in

node_modules/axios/index.d.ts:75

___

### httpsAgent

• `Optional` **httpsAgent**: `any`

#### Inherited from

AxiosRequestConfig.httpsAgent

#### Defined in

node_modules/axios/index.d.ts:76

___

### maxBodyLength

• `Optional` **maxBodyLength**: `number`

#### Inherited from

AxiosRequestConfig.maxBodyLength

#### Defined in

node_modules/axios/index.d.ts:72

___

### maxContentLength

• `Optional` **maxContentLength**: `number`

#### Inherited from

AxiosRequestConfig.maxContentLength

#### Defined in

node_modules/axios/index.d.ts:70

___

### maxRedirects

• `Optional` **maxRedirects**: `number`

#### Inherited from

AxiosRequestConfig.maxRedirects

#### Defined in

node_modules/axios/index.d.ts:73

___

### method

• `Optional` **method**: `Method`

#### Inherited from

AxiosRequestConfig.method

#### Defined in

node_modules/axios/index.d.ts:52

___

### params

• `Optional` **params**: `any`

#### Inherited from

AxiosRequestConfig.params

#### Defined in

node_modules/axios/index.d.ts:57

___

### proxy

• `Optional` **proxy**: ``false`` \| `AxiosProxyConfig`

#### Inherited from

AxiosRequestConfig.proxy

#### Defined in

node_modules/axios/index.d.ts:77

___

### responseType

• `Optional` **responseType**: `ResponseType`

#### Inherited from

AxiosRequestConfig.responseType

#### Defined in

node_modules/axios/index.d.ts:65

___

### socketPath

• `Optional` **socketPath**: `string`

#### Inherited from

AxiosRequestConfig.socketPath

#### Defined in

node_modules/axios/index.d.ts:74

___

### timeout

• `Optional` **timeout**: `number`

#### Inherited from

AxiosRequestConfig.timeout

#### Defined in

node_modules/axios/index.d.ts:60

___

### timeoutErrorMessage

• `Optional` **timeoutErrorMessage**: `string`

#### Inherited from

AxiosRequestConfig.timeoutErrorMessage

#### Defined in

node_modules/axios/index.d.ts:61

___

### transformRequest

• `Optional` **transformRequest**: `AxiosTransformer` \| `AxiosTransformer`[]

#### Inherited from

AxiosRequestConfig.transformRequest

#### Defined in

node_modules/axios/index.d.ts:54

___

### transformResponse

• `Optional` **transformResponse**: `AxiosTransformer` \| `AxiosTransformer`[]

#### Inherited from

AxiosRequestConfig.transformResponse

#### Defined in

node_modules/axios/index.d.ts:55

___

### transitional

• `Optional` **transitional**: `TransitionalOptions`

#### Inherited from

AxiosRequestConfig.transitional

#### Defined in

node_modules/axios/index.d.ts:80

___

### url

• `Optional` **url**: `string`

#### Inherited from

AxiosRequestConfig.url

#### Defined in

node_modules/axios/index.d.ts:51

___

### validateStatus

• `Optional` **validateStatus**: (`status`: `number`) => `boolean`

#### Type declaration

▸ (`status`): `boolean`

##### Parameters

| Name | Type |
| :------ | :------ |
| `status` | `number` |

##### Returns

`boolean`

#### Inherited from

AxiosRequestConfig.validateStatus

#### Defined in

node_modules/axios/index.d.ts:71

___

### withCredentials

• `Optional` **withCredentials**: `boolean`

#### Inherited from

AxiosRequestConfig.withCredentials

#### Defined in

node_modules/axios/index.d.ts:62

___

### xsrfCookieName

• `Optional` **xsrfCookieName**: `string`

#### Inherited from

AxiosRequestConfig.xsrfCookieName

#### Defined in

node_modules/axios/index.d.ts:66

___

### xsrfHeaderName

• `Optional` **xsrfHeaderName**: `string`

#### Inherited from

AxiosRequestConfig.xsrfHeaderName

#### Defined in

node_modules/axios/index.d.ts:67

## Methods

### onDownloadProgress

▸ `Optional` **onDownloadProgress**(`progressEvent`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `progressEvent` | `any` |

#### Returns

`void`

#### Inherited from

AxiosRequestConfig.onDownloadProgress

#### Defined in

node_modules/axios/index.d.ts:69

___

### onUploadProgress

▸ `Optional` **onUploadProgress**(`progressEvent`): `void`

#### Parameters

| Name | Type |
| :------ | :------ |
| `progressEvent` | `any` |

#### Returns

`void`

#### Inherited from

AxiosRequestConfig.onUploadProgress

#### Defined in

node_modules/axios/index.d.ts:68

___

### paramsSerializer

▸ `Optional` **paramsSerializer**(`params`): `string`

#### Parameters

| Name | Type |
| :------ | :------ |
| `params` | `any` |

#### Returns

`string`

#### Inherited from

AxiosRequestConfig.paramsSerializer

#### Defined in

node_modules/axios/index.d.ts:58
