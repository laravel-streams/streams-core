[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / IStream

# Interface: IStream<ID\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

## Hierarchy

- [`IBaseStream`](IBaseStream.md)<`ID`\>

  ↳ **`IStream`**

## Table of contents

### Properties

- [config](IStream.md#config)
- [created\_at](IStream.md#created_at)
- [fields](IStream.md#fields)
- [handle](IStream.md#handle)
- [id](IStream.md#id)
- [name](IStream.md#name)
- [routes](IStream.md#routes)
- [rules](IStream.md#rules)
- [source](IStream.md#source)
- [updated\_at](IStream.md#updated_at)
- [validators](IStream.md#validators)

## Properties

### config

• `Optional` **config**: `Record`<`string`, `any`\>

#### Defined in

[resources/lib/types/streams.ts:37](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L37)

___

### created\_at

• **created\_at**: `string`

#### Inherited from

[IBaseStream](IBaseStream.md).[created_at](IBaseStream.md#created_at)

#### Defined in

[resources/lib/types/streams.ts:21](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L21)

___

### fields

• **fields**: `Record`<`string`, [`Field`](../classes/Field.md) \| keyof [`Types`](fields.Types.md)\>

#### Inherited from

[IBaseStream](IBaseStream.md).[fields](IBaseStream.md#fields)

#### Defined in

[resources/lib/types/streams.ts:28](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L28)

___

### handle

• `Optional` **handle**: `ID`

#### Defined in

[resources/lib/types/streams.ts:34](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L34)

___

### id

• **id**: `ID`

#### Inherited from

[IBaseStream](IBaseStream.md).[id](IBaseStream.md#id)

#### Defined in

[resources/lib/types/streams.ts:20](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L20)

___

### name

• **name**: `string`

#### Inherited from

[IBaseStream](IBaseStream.md).[name](IBaseStream.md#name)

#### Defined in

[resources/lib/types/streams.ts:23](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L23)

___

### routes

• `Optional` **routes**: `any`[]

#### Defined in

[resources/lib/types/streams.ts:35](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L35)

___

### rules

• `Optional` **rules**: `Record`<`string`, `string` \| `object`\>

#### Inherited from

[IBaseStream](IBaseStream.md).[rules](IBaseStream.md#rules)

#### Defined in

[resources/lib/types/streams.ts:29](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L29)

___

### source

• **source**: `Object`

#### Index signature

▪ [key: `string`]: `any`

#### Type declaration

| Name | Type |
| :------ | :------ |
| `type` | `string` |

#### Inherited from

[IBaseStream](IBaseStream.md).[source](IBaseStream.md#source)

#### Defined in

[resources/lib/types/streams.ts:24](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L24)

___

### updated\_at

• **updated\_at**: `string`

#### Inherited from

[IBaseStream](IBaseStream.md).[updated_at](IBaseStream.md#updated_at)

#### Defined in

[resources/lib/types/streams.ts:22](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L22)

___

### validators

• `Optional` **validators**: `any`[]

#### Defined in

[resources/lib/types/streams.ts:36](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L36)
