[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Transformer

# Class: Transformer

## Table of contents

### Constructors

- [constructor](Transformer.md#constructor)

### Properties

- [typePrefix](Transformer.md#typeprefix)

### Accessors

- [prefixesLength](Transformer.md#prefixeslength)

### Methods

- [compress](Transformer.md#compress)
- [decode](Transformer.md#decode)
- [decompress](Transformer.md#decompress)
- [encode](Transformer.md#encode)

## Constructors

### constructor

• **new Transformer**()

## Properties

### typePrefix

▪ `Static` **typePrefix**: `string` = `'__ls_'`

#### Defined in

[resources/lib/Storage/Transformer.ts:4](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/Transformer.ts#L4)

## Accessors

### prefixesLength

• `Static` `get` **prefixesLength**(): `number`

#### Returns

`number`

#### Defined in

[resources/lib/Storage/Transformer.ts:5](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/Transformer.ts#L5)

## Methods

### compress

▸ `Static` **compress**(`value`): `string`

#### Parameters

| Name | Type |
| :------ | :------ |
| `value` | `any` |

#### Returns

`string`

#### Defined in

[resources/lib/Storage/Transformer.ts:7](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/Transformer.ts#L7)

___

### decode

▸ `Static` **decode**(`value`): `any`

#### Parameters

| Name | Type |
| :------ | :------ |
| `value` | `any` |

#### Returns

`any`

#### Defined in

[resources/lib/Storage/Transformer.ts:55](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/Transformer.ts#L55)

___

### decompress

▸ `Static` **decompress**(`value`): `any`

#### Parameters

| Name | Type |
| :------ | :------ |
| `value` | `any` |

#### Returns

`any`

#### Defined in

[resources/lib/Storage/Transformer.ts:11](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/Transformer.ts#L11)

___

### encode

▸ `Static` **encode**(`value`): `any`

#### Parameters

| Name | Type |
| :------ | :------ |
| `value` | `any` |

#### Returns

`any`

#### Defined in

[resources/lib/Storage/Transformer.ts:30](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/Transformer.ts#L30)
