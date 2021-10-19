[Streams Platform Client Api - v1.0.2](../README.md) / [Exports](../modules.md) / Criteria

# Class: Criteria<ID\>

## Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

## Table of contents

### Constructors

- [constructor](Criteria.md#constructor)

### Properties

- [http](Criteria.md#http)
- [parameters](Criteria.md#parameters)
- [stream](Criteria.md#stream)

### Methods

- [addParameter](Criteria.md#addparameter)
- [cache](Criteria.md#cache)
- [compileStatements](Criteria.md#compilestatements)
- [create](Criteria.md#create)
- [delete](Criteria.md#delete)
- [find](Criteria.md#find)
- [first](Criteria.md#first)
- [get](Criteria.md#get)
- [getParameters](Criteria.md#getparameters)
- [limit](Criteria.md#limit)
- [newInstance](Criteria.md#newinstance)
- [orWhere](Criteria.md#orwhere)
- [orderBy](Criteria.md#orderby)
- [paginate](Criteria.md#paginate)
- [save](Criteria.md#save)
- [setParameters](Criteria.md#setparameters)
- [where](Criteria.md#where)

## Constructors

### constructor

• **new Criteria**<`ID`\>(`stream`)

Create a new instance.

#### Type parameters

| Name | Type |
| :------ | :------ |
| `ID` | extends `string``string` |

#### Parameters

| Name | Type |
| :------ | :------ |
| `stream` | [`Stream`](Stream.md)<`string`\> |

#### Defined in

[resources/lib/Streams/Criteria.ts:66](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L66)

## Properties

### http

• **http**: [`Http`](Http.md)

#### Defined in

[resources/lib/Streams/Criteria.ts:57](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L57)

___

### parameters

• **parameters**: [`CriteriaParameter`](../interfaces/CriteriaParameter.md)[] = `[]`

#### Defined in

[resources/lib/Streams/Criteria.ts:59](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L59)

___

### stream

• `Protected` **stream**: [`Stream`](Stream.md)<`string`\>

## Methods

### addParameter

▸ `Protected` **addParameter**(`name`, `value`): [`Criteria`](Criteria.md)<`ID`\>

Add a statement.

#### Parameters

| Name | Type |
| :------ | :------ |
| `name` | `string` |
| `value` | `any` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:290](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L290)

___

### cache

▸ **cache**(): [`Criteria`](Criteria.md)<`ID`\>

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:90](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L90)

___

### compileStatements

▸ **compileStatements**(): {}[]

Return standardized parameters.

#### Returns

{}[]

#### Defined in

[resources/lib/Streams/Criteria.ts:302](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L302)

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

[resources/lib/Streams/Criteria.ts:209](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L209)

___

### delete

▸ **delete**(): [`Criteria`](Criteria.md)<`ID`\>

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:231](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L231)

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

#### Defined in

[resources/lib/Streams/Criteria.ts:74](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L74)

___

### first

▸ **first**(): `Promise`<[`Entry`](Entry.md)<`ID`\> & [`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>\>

Return the first result.

#### Returns

`Promise`<[`Entry`](Entry.md)<`ID`\> & [`IBaseStream`](../interfaces/IBaseStream.md)<`ID`\>\>

#### Defined in

[resources/lib/Streams/Criteria.ts:83](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L83)

___

### get

▸ **get**<`T`\>(): `Promise`<[`EntryCollection`](EntryCollection.md)<`any`\>\>

Get the criteria results.

#### Type parameters

| Name |
| :------ |
| `T` |

#### Returns

`Promise`<[`EntryCollection`](EntryCollection.md)<`any`\>\>

#### Defined in

[resources/lib/Streams/Criteria.ts:192](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L192)

___

### getParameters

▸ **getParameters**(): `any`

Get the parameters.

#### Returns

`any`

#### Defined in

[resources/lib/Streams/Criteria.ts:266](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L266)

___

### limit

▸ **limit**(`value`): [`Criteria`](Criteria.md)<`ID`\>

Limit the entries returned.

#### Parameters

| Name | Type |
| :------ | :------ |
| `value` | `number` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:112](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L112)

___

### newInstance

▸ **newInstance**(`attributes`): [`Entry`](Entry.md)<`string`\>

Return an entry instance.

#### Parameters

| Name | Type |
| :------ | :------ |
| `attributes` | `any` |

#### Returns

[`Entry`](Entry.md)<`string`\>

Entry

#### Defined in

[resources/lib/Streams/Criteria.ts:257](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L257)

___

### orWhere

▸ **orWhere**(`key`, `operator`, `value`): [`Criteria`](Criteria.md)<`ID`\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `operator` | [`Operator`](../modules.md#operator) |
| `value` | `any` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:160](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L160)

▸ **orWhere**(`key`, `value`): [`Criteria`](Criteria.md)<`ID`\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `value` | `any` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:161](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L161)

___

### orderBy

▸ **orderBy**(`key`, `direction?`): [`Criteria`](Criteria.md)<`ID`\>

Order the query by field/direction.

#### Parameters

| Name | Type | Default value |
| :------ | :------ | :------ |
| `key` | `string` | `undefined` |
| `direction` | [`OrderByDirection`](../modules.md#orderbydirection) | `'desc'` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:99](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L99)

___

### paginate

▸ **paginate**<`T`\>(`per_page?`, `page?`): `Promise`<[`PaginatedEntryCollection`](PaginatedEntryCollection.md)<`any`\>\>

Get paginated criteria results.

#### Type parameters

| Name |
| :------ |
| `T` |

#### Parameters

| Name | Type | Default value |
| :------ | :------ | :------ |
| `per_page` | `number` | `100` |
| `page` | `number` | `1` |

#### Returns

`Promise`<[`PaginatedEntryCollection`](PaginatedEntryCollection.md)<`any`\>\>

#### Defined in

[resources/lib/Streams/Criteria.ts:242](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L242)

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

[resources/lib/Streams/Criteria.ts:224](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L224)

___

### setParameters

▸ **setParameters**(`parameters`): [`Criteria`](Criteria.md)<`ID`\>

Set the parameters.

#### Parameters

| Name | Type |
| :------ | :------ |
| `parameters` | `any` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:276](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L276)

___

### where

▸ **where**(`key`, `operator`, `value`, `nested`): [`Criteria`](Criteria.md)<`ID`\>

Constrain the query by a typical
field, operator, value argument.

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `operator` | [`Operator`](../modules.md#operator) |
| `value` | `any` |
| `nested` | `any` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:126](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L126)

▸ **where**(`key`, `operator`, `value`): [`Criteria`](Criteria.md)<`ID`\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `operator` | [`Operator`](../modules.md#operator) |
| `value` | `any` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:127](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L127)

▸ **where**(`key`, `value`): [`Criteria`](Criteria.md)<`ID`\>

#### Parameters

| Name | Type |
| :------ | :------ |
| `key` | `string` |
| `value` | `any` |

#### Returns

[`Criteria`](Criteria.md)<`ID`\>

#### Defined in

[resources/lib/Streams/Criteria.ts:128](https://github.com/laravel-streams/streams-core/blob/e866e1454/resources/lib/Streams/Criteria.ts#L128)
