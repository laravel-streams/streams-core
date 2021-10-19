[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / IBaseStream

# Interface: IBaseStream<ID\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

## Hierarchy

- **`IBaseStream`**

  ↳ [`IStream`](IStream.md)

  ↳ [`Users`](streams.Users.md)

  ↳ [`Pages`](streams.Pages.md)

## Table of contents

### Properties

- [created\_at](IBaseStream.md#created_at)
- [fields](IBaseStream.md#fields)
- [id](IBaseStream.md#id)
- [name](IBaseStream.md#name)
- [rules](IBaseStream.md#rules)
- [source](IBaseStream.md#source)
- [updated\_at](IBaseStream.md#updated_at)

## Properties

### created\_at

• **created\_at**: `string`

#### Defined in

[resources/lib/types/streams.ts:21](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L21)

___

### fields

• **fields**: `Record`<`string`, [`Field`](../classes/Field.md) \| keyof [`Types`](fields.Types.md)\>

#### Defined in

[resources/lib/types/streams.ts:28](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L28)

___

### id

• **id**: `ID`

#### Defined in

[resources/lib/types/streams.ts:20](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L20)

___

### name

• **name**: `string`

#### Defined in

[resources/lib/types/streams.ts:23](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L23)

___

### rules

• `Optional` **rules**: `Record`<`string`, `string` \| `object`\>

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

#### Defined in

[resources/lib/types/streams.ts:24](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L24)

___

### updated\_at

• **updated\_at**: `string`

#### Defined in

[resources/lib/types/streams.ts:22](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L22)
