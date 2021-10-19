[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Entry

# Class: Entry<ID\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

## Table of contents

### Constructors

- [constructor](Entry.md#constructor)

### Properties

- [\_data](Entry.md#_data)
- [\_fresh](Entry.md#_fresh)
- [\_stream](Entry.md#_stream)
- [http](Entry.md#http)

### Accessors

- [stream](Entry.md#stream)

### Methods

- [save](Entry.md#save)
- [validator](Entry.md#validator)

## Constructors

### constructor

• **new Entry**<`ID`\>(`_stream`, `_data?`, `_fresh?`)

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

#### Parameters

| Name | Type | Default value |
| :------ | :------ | :------ |
| `_stream` | [`Stream`](Stream.md)<`ID`\> | `undefined` |
| `_data` | `any` | `{}` |
| `_fresh` | `boolean` | `true` |

#### Defined in

[resources/lib/Streams/Entry.ts:12](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Entry.ts#L12)

## Properties

### \_data

• `Protected` **\_data**: `any` = `{}`

___

### \_fresh

• `Protected` **\_fresh**: `boolean` = `true`

___

### \_stream

• `Protected` **\_stream**: [`Stream`](Stream.md)<`ID`\>

___

### http

• **http**: [`Http`](Http.md)

#### Defined in

[resources/lib/Streams/Entry.ts:10](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Entry.ts#L10)

## Accessors

### stream

• `get` **stream**(): [`Stream`](Stream.md)<`ID`\>

#### Returns

[`Stream`](Stream.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Entry.ts:36](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Entry.ts#L36)

## Methods

### save

▸ **save**(): `Promise`<`Boolean`\>

#### Returns

`Promise`<`Boolean`\>

#### Defined in

[resources/lib/Streams/Entry.ts:40](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Entry.ts#L40)

___

### validator

▸ **validator**(): `void`

#### Returns

`void`

#### Defined in

[resources/lib/Streams/Entry.ts:53](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Entry.ts#L53)
