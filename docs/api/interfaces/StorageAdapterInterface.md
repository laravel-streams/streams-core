[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / StorageAdapterInterface

# Interface: StorageAdapterInterface

## Implemented by

- [`StorageAdapter`](../classes/StorageAdapter.md)

## Table of contents

### Methods

- [clear](StorageAdapterInterface.md#clear)
- [get](StorageAdapterInterface.md#get)
- [has](StorageAdapterInterface.md#has)
- [set](StorageAdapterInterface.md#set)
- [unset](StorageAdapterInterface.md#unset)

## Methods

### clear

▸ **clear**(): [`StorageAdapterInterface`](StorageAdapterInterface.md)

#### Returns

[`StorageAdapterInterface`](StorageAdapterInterface.md)

#### Defined in

[resources/lib/Storage/StorageAdapterInterface.ts:10](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapterInterface.ts#L10)

___

### get

▸ **get**<`T`\>(`key`, `defaultValue?`): `T`

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `defaultValue?` | `any` |

#### Returns

`T`

#### Defined in

[resources/lib/Storage/StorageAdapterInterface.ts:2](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapterInterface.ts#L2)

___

### has

▸ **has**(`key`): `boolean`

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |

#### Returns

`boolean`

#### Defined in

[resources/lib/Storage/StorageAdapterInterface.ts:6](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapterInterface.ts#L6)

___

### set

▸ **set**(`key`, `value`): [`StorageAdapterInterface`](StorageAdapterInterface.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `value` | `any` |

#### Returns

[`StorageAdapterInterface`](StorageAdapterInterface.md)

#### Defined in

[resources/lib/Storage/StorageAdapterInterface.ts:4](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapterInterface.ts#L4)

___

### unset

▸ **unset**(`key`): [`StorageAdapterInterface`](StorageAdapterInterface.md)

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |

#### Returns

[`StorageAdapterInterface`](StorageAdapterInterface.md)

#### Defined in

[resources/lib/Storage/StorageAdapterInterface.ts:8](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Storage/StorageAdapterInterface.ts#L8)
