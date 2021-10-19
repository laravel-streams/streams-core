[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / [streams](../modules/streams.md) / Users

# Interface: Users

[streams](../modules/streams.md).Users

## Hierarchy

- [`IBaseStream`](IBaseStream.md)<``"users"``\>

  ↳ **`Users`**

## Table of contents

### Properties

- [created\_at](streams.Users.md#created_at)
- [fields](streams.Users.md#fields)
- [id](streams.Users.md#id)
- [name](streams.Users.md#name)
- [rules](streams.Users.md#rules)
- [source](streams.Users.md#source)
- [ui](streams.Users.md#ui)
- [updated\_at](streams.Users.md#updated_at)

## Properties

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

### id

• **id**: ``"users"``

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

### ui

• **ui**: `Object`

#### Index signature

▪ [key: `string`]: `any`

#### Type declaration

| Name | Type |
| :------ | :------ |
| `form` | `any`[] |
| `table` | [`Table`](ui.table.Table.md)<[``"id"``, ``"email"``], [``"edit"``]\> |

#### Defined in

[resources/lib/types/streams.ts:115](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L115)

___

### updated\_at

• **updated\_at**: `string`

#### Inherited from

[IBaseStream](IBaseStream.md).[updated_at](IBaseStream.md#updated_at)

#### Defined in

[resources/lib/types/streams.ts:22](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L22)
