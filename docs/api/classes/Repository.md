[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Repository

# Class: Repository<ID\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

## Table of contents

### Constructors

- [constructor](Repository.md#constructor)

### Properties

- [http](Repository.md#http)
- [stream](Repository.md#stream)

### Methods

- [all](Repository.md#all)
- [create](Repository.md#create)
- [delete](Repository.md#delete)
- [find](Repository.md#find)
- [findAll](Repository.md#findall)
- [findAllWhere](Repository.md#findallwhere)
- [findBy](Repository.md#findby)
- [newCriteria](Repository.md#newcriteria)
- [newInstance](Repository.md#newinstance)
- [save](Repository.md#save)
- [truncate](Repository.md#truncate)

## Constructors

### constructor

• **new Repository**<`ID`\>(`stream`)

Create a new repository instance.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | [`Stream`](Stream.md)<`string`\> |

#### Defined in

[resources/lib/Streams/Repository.ts:18](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L18)

## Properties

### http

• `Protected` **http**: [`Http`](Http.md)

#### Defined in

[resources/lib/Streams/Repository.ts:11](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L11)

___

### stream

• `Protected` **stream**: [`Stream`](Stream.md)<`string`\>

## Methods

### all

▸ **all**(): `Promise`<[`EntryCollection`](EntryCollection.md)<`any`\>\>

Return all items.

#### Returns

`Promise`<[`EntryCollection`](EntryCollection.md)<`any`\>\>

EntryCollection

#### Defined in

[resources/lib/Streams/Repository.ts:25](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L25)

___

### create

▸ **create**(`attributes`): `Promise`<[`Entry`](Entry.md)<`string`\>\>

Create a new entry.

#### Parameters

| Name | Type |
| :------ | :------ |
| `attributes` | `any` |

#### Returns

`Promise`<[`Entry`](Entry.md)<`string`\>\>

#### Defined in

[resources/lib/Streams/Repository.ts:95](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L95)

___

### delete

▸ **delete**(`entry`): `Promise`<`Boolean`\>

Save an entry.

#### Parameters

| Name | Type |
| :------ | :------ |
| `entry` | `any` |

#### Returns

`Promise`<`Boolean`\>

#### Defined in

[resources/lib/Streams/Repository.ts:123](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L123)

___

### find

▸ **find**<`ID`\>(`id`): `Promise`<[`Entry`](Entry.md)<`string`\>\>

Find an entry by ID.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `id` | `ID` |

#### Returns

`Promise`<[`Entry`](Entry.md)<`string`\>\>

Entry

#### Defined in

[resources/lib/Streams/Repository.ts:40](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L40)

___

### findAll

▸ **findAll**(`ids`): `Promise`<[`EntryCollection`](EntryCollection.md)<`any`\>\>

Find all records by IDs.

#### Parameters

| Name | Type |
| :------ | :------ |
| `ids` | `any` |

#### Returns

`Promise`<[`EntryCollection`](EntryCollection.md)<`any`\>\>

EntryCollection

#### Defined in

[resources/lib/Streams/Repository.ts:53](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L53)

___

### findAllWhere

▸ **findAllWhere**<`ID`, `VID`\>(`field`, `value`): `Promise`<[`EntryCollection`](EntryCollection.md)<`any`\>\>

Find all entries by field value.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |
| `VID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `field` | `ID` |
| `value` | `VID` |

#### Returns

`Promise`<[`EntryCollection`](EntryCollection.md)<`any`\>\>

EntryCollection

#### Defined in

[resources/lib/Streams/Repository.ts:82](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L82)

___

### findBy

▸ **findBy**<`ID`, `VID`\>(`field`, `value`): `Promise`<[`Entry`](Entry.md)<`string`\>\>

Find an entry by a field value.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string` |
| `VID` | extends `string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `field` | `ID` |
| `value` | `VID` |

#### Returns

`Promise`<[`Entry`](Entry.md)<`string`\>\>

Entry

#### Defined in

[resources/lib/Streams/Repository.ts:67](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L67)

___

### newCriteria

▸ **newCriteria**(): [`Criteria`](Criteria.md)<`ID`\>

Return a new entry criteria.

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

Criteria

#### Defined in

[resources/lib/Streams/Repository.ts:147](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L147)

___

### newInstance

▸ **newInstance**(`attributes`): [`Entry`](Entry.md)<`string`\>

Return a new instance.

#### Parameters

| Name | Type |
| :------ | :------ |
| `attributes` | `any` |

#### Returns

[`Entry`](Entry.md)<`string`\>

#### Defined in

[resources/lib/Streams/Repository.ts:138](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L138)

___

### save

▸ **save**(`entry`): `Promise`<`Boolean`\>

Save an entry.

#### Parameters

| Name | Type |
| :------ | :------ |
| `entry` | [`Entry`](Entry.md)<`string`\> |

#### Returns

`Promise`<`Boolean`\>

#### Defined in

[resources/lib/Streams/Repository.ts:110](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L110)

___

### truncate

▸ **truncate**(): [`Repository`](Repository.md)<`ID`\>

#### Returns

[`Repository`](Repository.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Repository.ts:130](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Repository.ts#L130)
