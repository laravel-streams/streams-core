[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Http

# Class: Http

## Table of contents

### Constructors

- [constructor](Http.md#constructor)

### Properties

- [Axios](Http.md#axios)
- [axios](Http.md#axios)
- [cancelTokenSource](Http.md#canceltokensource)

### Methods

- [constructed](Http.md#constructed)
- [delete](Http.md#delete)
- [deleteEntry](Http.md#deleteentry)
- [deleteStream](Http.md#deletestream)
- [get](Http.md#get)
- [getEntries](Http.md#getentries)
- [getEntry](Http.md#getentry)
- [getStream](Http.md#getstream)
- [getStreams](Http.md#getstreams)
- [getUri](Http.md#geturi)
- [head](Http.md#head)
- [options](Http.md#options)
- [patch](Http.md#patch)
- [patchEntry](Http.md#patchentry)
- [patchStream](Http.md#patchstream)
- [post](Http.md#post)
- [postEntry](Http.md#postentry)
- [postStream](Http.md#poststream)
- [put](Http.md#put)
- [putEntry](Http.md#putentry)
- [putStream](Http.md#putstream)
- [request](Http.md#request)

## Constructors

### constructor

• **new Http**()

## Properties

### Axios

• **Axios**: `AxiosStatic`

#### Defined in

[resources/lib/Streams/Http.ts:11](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L11)

___

### axios

• **axios**: `AxiosInstance`

#### Defined in

[resources/lib/Streams/Http.ts:12](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L12)

___

### cancelTokenSource

• `Protected` **cancelTokenSource**: `CancelTokenSource`

#### Defined in

[resources/lib/Streams/Http.ts:13](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L13)

## Methods

### constructed

▸ `Protected` **constructed**(): `void`

#### Returns

`void`

#### Defined in

[resources/lib/Streams/Http.ts:98](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L98)

___

### delete

▸ **delete**<`T`, `R`\>(`url`, `config?`): `Promise`<`R`\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |
| `R` | [`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\> |

#### Parameters

| Name | Type |
| :------ | :------ |
| `url` | `string` |
| `config?` | `AxiosRequestConfig` |

#### Returns

`Promise`<`R`\>

#### Defined in

[resources/lib/Streams/Http.ts:85](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L85)

___

### deleteEntry

▸ **deleteEntry**<`ID`, `EID`\>(`stream`, `entry`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |
| `EID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `entry` | `EID` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:76](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L76)

___

### deleteStream

▸ **deleteStream**<`ID`\>(`stream`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:40](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L40)

___

### get

▸ **get**<`T`, `R`\>(`url`, `config?`): `Promise`<`R`\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |
| `R` | [`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\> |

#### Parameters

| Name | Type |
| :------ | :------ |
| `url` | `string` |
| `config?` | `AxiosRequestConfig` |

#### Returns

`Promise`<`R`\>

#### Defined in

[resources/lib/Streams/Http.ts:83](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L83)

___

### getEntries

▸ **getEntries**<`DATA`, `TYPE`, `ID`\>(`stream`, `data?`, `params?`, `config?`): `Promise`<[`Responses`](../interfaces/Http.Responses.md)<`DATA`\>[`TYPE`]\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `DATA` | `DATA` |
| `TYPE` | extends keyof [`Responses`](../interfaces/Http.Responses.md)<`DATA`\>``"entries"`` |
| `ID` | extends `string``string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `data` | `any` |
| `params` | `any` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`Responses`](../interfaces/Http.Responses.md)<`DATA`\>[`TYPE`]\>

#### Defined in

[resources/lib/Streams/Http.ts:44](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L44)

___

### getEntry

▸ **getEntry**<`ID`, `EID`\>(`stream`, `entry`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |
| `EID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `entry` | `EID` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:62](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L62)

___

### getStream

▸ **getStream**<`ID`\>(`stream`, `params?`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `params` | `any` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:25](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L25)

___

### getStreams

▸ **getStreams**(`params?`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `params` | `any` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:15](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L15)

___

### getUri

▸ **getUri**(`config?`): `string`

#### Parameters

| Name | Type |
| :------ | :------ |
| `config?` | `AxiosRequestConfig` |

#### Returns

`string`

#### Defined in

[resources/lib/Streams/Http.ts:81](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L81)

___

### head

▸ **head**<`T`, `R`\>(`url`, `config?`): `Promise`<`R`\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |
| `R` | [`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\> |

#### Parameters

| Name | Type |
| :------ | :------ |
| `url` | `string` |
| `config?` | `AxiosRequestConfig` |

#### Returns

`Promise`<`R`\>

#### Defined in

[resources/lib/Streams/Http.ts:87](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L87)

___

### options

▸ **options**<`T`, `R`\>(`url`, `config?`): `Promise`<`R`\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |
| `R` | [`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\> |

#### Parameters

| Name | Type |
| :------ | :------ |
| `url` | `string` |
| `config?` | `AxiosRequestConfig` |

#### Returns

`Promise`<`R`\>

#### Defined in

[resources/lib/Streams/Http.ts:89](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L89)

___

### patch

▸ **patch**<`T`, `R`\>(`url`, `data?`, `config?`): `Promise`<`R`\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |
| `R` | [`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\> |

#### Parameters

| Name | Type |
| :------ | :------ |
| `url` | `string` |
| `data?` | `any` |
| `config?` | `AxiosRequestConfig` |

#### Returns

`Promise`<`R`\>

#### Defined in

[resources/lib/Streams/Http.ts:95](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L95)

___

### patchEntry

▸ **patchEntry**<`ID`, `EID`\>(`stream`, `entry`, `data?`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |
| `EID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `entry` | `EID` |
| `data` | `any` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:66](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L66)

___

### patchStream

▸ **patchStream**<`ID`\>(`stream`, `params?`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `params` | `any` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:30](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L30)

___

### post

▸ **post**<`T`, `R`\>(`url`, `data?`, `config?`): `Promise`<`R`\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |
| `R` | [`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\> |

#### Parameters

| Name | Type |
| :------ | :------ |
| `url` | `string` |
| `data?` | `any` |
| `config?` | `AxiosRequestConfig` |

#### Returns

`Promise`<`R`\>

#### Defined in

[resources/lib/Streams/Http.ts:91](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L91)

___

### postEntry

▸ **postEntry**<`ID`\>(`stream`, `data?`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `data` | `any` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:56](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L56)

___

### postStream

▸ **postStream**<`T`\>(`data`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `data` | `T` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:20](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L20)

___

### put

▸ **put**<`T`, `R`\>(`url`, `data?`, `config?`): `Promise`<`R`\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |
| `R` | [`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\> |

#### Parameters

| Name | Type |
| :------ | :------ |
| `url` | `string` |
| `data?` | `any` |
| `config?` | `AxiosRequestConfig` |

#### Returns

`Promise`<`R`\>

#### Defined in

[resources/lib/Streams/Http.ts:93](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L93)

___

### putEntry

▸ **putEntry**<`ID`, `EID`\>(`stream`, `entry`, `data?`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |
| `EID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `entry` | `EID` |
| `data` | `any` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<`any`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:71](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L71)

___

### putStream

▸ **putStream**<`ID`\>(`stream`, `params?`, `config?`): `Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | `ID` |
| `params` | `any` |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<[`IStreamResponse`](../interfaces/IStreamResponse.md)<[`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\>\>

#### Defined in

[resources/lib/Streams/Http.ts:35](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L35)

___

### request

▸ **request**<`T`, `R`\>(`config`): `Promise`<`R`\>

#### Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `any` |
| `R` | [`IStreamResponse`](../interfaces/IStreamResponse.md)<`T`, [`IStreamMeta`](../interfaces/IStreamMeta.md), [`IStreamLinks`](../modules.md#istreamlinks)<``"entries"`` \| ``"self"``\>\> |

#### Parameters

| Name | Type |
| :------ | :------ |
| `config` | `AxiosRequestConfig` |

#### Returns

`Promise`<`R`\>

#### Defined in

[resources/lib/Streams/Http.ts:102](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Http.ts#L102)
