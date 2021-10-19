[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / [Http](../modules/Http.md) / StreamResponse

# Interface: StreamResponse<T, M, L\>

[Http](../modules/Http.md).StreamResponse

## Type parameters

| Name | Type |
| :------ | :------ |
| `T` | `T` |
| `M` | extends [`IStreamMeta`](IStreamMeta.md) |
| `L` | [`IStreamLinks`](../modules.md#istreamlinks)<`any`\> |

## Hierarchy

- [`IStreamResponse`](IStreamResponse.md)<`T`, `M`, `L`\>

  ↳ **`StreamResponse`**

## Table of contents

### Properties

- [data](Http.StreamResponse.md#data)
- [errors](Http.StreamResponse.md#errors)
- [links](Http.StreamResponse.md#links)
- [meta](Http.StreamResponse.md#meta)

## Properties

### data

• **data**: `T`

#### Inherited from

[IStreamResponse](IStreamResponse.md).[data](IStreamResponse.md#data)

#### Defined in

[resources/lib/types/streams.ts:13](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L13)

___

### errors

• `Optional` **errors**: `string`[] \| `Record`<`string`, `string` \| `string`[]\>

#### Inherited from

[IStreamResponse](IStreamResponse.md).[errors](IStreamResponse.md#errors)

#### Defined in

[resources/lib/types/streams.ts:16](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L16)

___

### links

• **links**: `L`

#### Inherited from

[IStreamResponse](IStreamResponse.md).[links](IStreamResponse.md#links)

#### Defined in

[resources/lib/types/streams.ts:15](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L15)

___

### meta

• **meta**: `M`

#### Inherited from

[IStreamResponse](IStreamResponse.md).[meta](IStreamResponse.md#meta)

#### Defined in

[resources/lib/types/streams.ts:14](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/types/streams.ts#L14)
