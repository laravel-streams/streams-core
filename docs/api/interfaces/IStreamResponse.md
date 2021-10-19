[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / IStreamResponse

# Interface: IStreamResponse<T, META, LINKS\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `T` | extends `any``any` |
| `META` | extends [`IStreamMeta`](IStreamMeta.md)[`IStreamMeta`](IStreamMeta.md) |
| `LINKS` | [`IStreamLinks`](../modules.md#istreamlinks)<``"self"`` \| ``"entries"``\> |

## Hierarchy

- **`IStreamResponse`**

  ↳ [`StreamResponse`](Http.StreamResponse.md)

## Table of contents

### Properties

- [data](IStreamResponse.md#data)
- [errors](IStreamResponse.md#errors)
- [links](IStreamResponse.md#links)
- [meta](IStreamResponse.md#meta)

## Properties

### data

• **data**: `T`

#### Defined in

[resources/lib/types/streams.ts:13](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L13)

___

### errors

• `Optional` **errors**: `string`[] \| `Record`<`string`, `string` \| `string`[]\>

#### Defined in

[resources/lib/types/streams.ts:16](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L16)

___

### links

• **links**: `LINKS`

#### Defined in

[resources/lib/types/streams.ts:15](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L15)

___

### meta

• **meta**: `META`

#### Defined in

[resources/lib/types/streams.ts:14](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L14)
