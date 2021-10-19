[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Streams

# Class: Streams

## Table of contents

### Constructors

- [constructor](Streams.md#constructor)

### Properties

- [config](Streams.md#config)
- [http](Streams.md#http)

### Methods

- [all](Streams.md#all)
- [collection](Streams.md#collection)
- [entries](Streams.md#entries)
- [make](Streams.md#make)
- [repository](Streams.md#repository)

## Constructors

### constructor

• **new Streams**()

## Properties

### config

• **config**: [`Config`](../modules.md#config)

#### Defined in

[resources/lib/Streams/Streams.ts:12](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Streams.ts#L12)

___

### http

• **http**: [`Http`](Http.md)

#### Defined in

[resources/lib/Streams/Streams.ts:13](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Streams.ts#L13)

## Methods

### all

▸ **all**(): `Promise`<[`Stream`](Stream.md)<`string`\>[]\>

Return all streams.

#### Returns

`Promise`<[`Stream`](Stream.md)<`string`\>[]\>

#### Defined in

[resources/lib/Streams/Streams.ts:20](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Streams.ts#L20)

___

### collection

▸ **collection**(): `void`

Return the Streams collection.

#### Returns

`void`

#### Defined in

[resources/lib/Streams/Streams.ts:69](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Streams.ts#L69)

___

### entries

▸ **entries**<`ID`\>(`id`): `Promise`<[`Criteria`](Criteria.md)<`string`\>\>

Return an entry criteria.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `id` | `ID` |

#### Returns

`Promise`<[`Criteria`](Criteria.md)<`string`\>\>

Criteria

#### Defined in

[resources/lib/Streams/Streams.ts:46](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Streams.ts#L46)

___

### make

▸ **make**<`ID`\>(`id`): `Promise`<[`Stream`](Stream.md)<`ID`\>\>

Make a stream instance.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `id` | `ID` |

#### Returns

`Promise`<[`Stream`](Stream.md)<`ID`\>\>

#### Defined in

[resources/lib/Streams/Streams.ts:33](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Streams.ts#L33)

___

### repository

▸ **repository**<`ID`\>(`id`): `Promise`<[`Repository`](Repository.md)<`string`\>\>

Return an entry repository.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `id` | `ID` |

#### Returns

`Promise`<[`Repository`](Repository.md)<`string`\>\>

#### Defined in

[resources/lib/Streams/Streams.ts:59](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Streams.ts#L59)
